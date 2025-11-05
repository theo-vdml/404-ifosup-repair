<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Filterable
 *
 * Adds dynamic filtering capabilities to Eloquent models.
 * Supports filtering on simple columns, nested relationships, and various operators.
 *
 * @property array $filterables List of allowed fields for filtering with allowed operators (optional)
 *   e.g., ['status.code' => ['eq'], 'title' => ['like'], 'created_at' => ['gte', 'lte']]
 *   If empty array for field, allows all operators.
 */
trait Filterable
{
    /**
     * Mapping of named operators to SQL operators.
     */
    protected array $operatorMap = [
        'eq' => '=',
        'neq' => '!=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'like' => 'like',
    ];
    /**
     * Scope to apply dynamic filtering based on query parameters.
     *
     * Reads 'filter' parameter from the HTTP request (array of field => [operator => value])
     * and applies the corresponding filters.
     *
     * @param Builder $query Eloquent query builder instance
     * @param array|null $allowed List of allowed fields. If null, uses $this->filterables or ['*']
     *
     * @return Builder The modified query builder
     */
    public function scopeFiltered($query, ?array $allowed = null)
    {
        $filters = request('filter', []);

        if (empty($filters)) {
            return $query;
        }

        $allowed ??= property_exists($this, 'filterables') ? $this->filterables : ['*'];

        foreach ($filters as $field => $operators) {
            if (!is_array($operators)) {
                continue;
            }

            // Check if field is allowed
            if (!in_array($field, array_keys($allowed)) && !in_array('*', $allowed)) {
                continue;
            }

            $allowedOps = $allowed[$field] ?? [];

            // Handle joins once per field
            $joinQuery = $query;
            $actualColumn = $field;
            if (str_contains($field, '.')) {
                [$joinQuery, $actualColumn] = $this->applyJoinsForFilter($query, $field);
            }

            foreach ($operators as $operator => $value) {
                if (empty($value)) {
                    continue;
                }

                // Check if operator is allowed for field
                if (!empty($allowedOps) && !in_array($operator, $allowedOps)) {
                    continue;
                }

                $joinQuery = $this->applyFilterableColumn($joinQuery, $actualColumn, $operator, $value);
            }
        }

        return $query;
    }

    /**
     * Applies filtering on a specific column.
     *
     * Handles operators and nested relationships.
     *
     * @param Builder $query Eloquent query builder instance
     * @param string $column Column name (already processed for joins)
     * @param string $operator Named operator ('eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'like')
     * @param mixed $value Filter value
     *
     * @return Builder The modified query builder with applied filter
     */
    protected function applyFilterableColumn($query, string $column, string $operator, $value)
    {
        $sqlOperator = $this->operatorMap[$operator] ?? $operator;

        // Apply filter based on operator
        if ($sqlOperator === 'like') {
            return $query->where($column, $sqlOperator, '%' . $value . '%');
        }

        return $query->where($column, $sqlOperator, $value);
    }

    /**
     * Applies necessary joins for nested relationships in filtering.
     *
     * @param Builder $query
     * @param string $column
     * @return array [modified query, actual column]
     */
    protected function applyJoinsForFilter($query, string $column)
    {
        $parts = explode('.', $column);
        $base = $this;
        $currentQuery = $query;
        $joinedPath = [];

        while (count($parts) > 1) {
            $relation = array_shift($parts);

            if (!method_exists($base, $relation)) {
                return [$query, $column];
            }

            $relationQuery = $base->$relation();
            $related = $relationQuery->getRelated();
            $table = $related->getTable();

            $aliasPath = array_merge($joinedPath, [$relation]);
            $alias = implode('_', $aliasPath);
            $joinedPath = $aliasPath;

            $alreadyJoined = collect($currentQuery->getQuery()->joins ?? [])
                ->pluck('table')
                ->contains("{$table} as {$alias}");

            if (!$alreadyJoined) {
                $foreignKey = $relationQuery->getQualifiedForeignKeyName();
                $ownerKey = $relationQuery->getQualifiedOwnerKeyName();
                $ownerKeyOnAlias = str_replace($related->getTable() . '.', $alias . '.', $ownerKey);

                $currentQuery->leftJoin("{$table} as {$alias}", $foreignKey, '=', $ownerKeyOnAlias);
            }

            $base = $related;
        }

        $col = array_shift($parts);
        return [$currentQuery, "{$alias}.{$col}"];
    }
}

<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

/**
 * Trait Sortable
 *
 * Adds dynamic sorting capabilities to Eloquent models.
 * Supports sorting on simple columns, multiple columns, and nested relationships.
 *
 * @property array $sortables List of allowed fields for sorting (optional)
 * @property array $multiColumnSorts Mapping of multi-column sorts (optional)
 */
trait Sortable
{
    /**
     * Scope to apply dynamic sorting based on query parameters.
     *
     * Reads 'sort' and 'direction' parameters from the HTTP request and applies
     * the corresponding sort.
     *
     * @param Builder $query Eloquent query builder instance
     * @param array|null $allowed List of allowed fields. If null, uses $this->sortables or ['*']
     *
     * @return Builder The modified query builder
     */
    public function scopeSorted($query, ?string $defaultSort = null, ?string $defaultDir = null, ?array $allowed = null)
    {
        $sort = request('sort', $defaultSort);
        $dir = strtolower(request('direction', $defaultDir ?? 'asc'));

        // If no sort field is provided, return the query unmodified
        if (!$sort) {
            return $query;
        }

        // If the sort field is not allowed, return the query unmodified
        $allowed ??= property_exists($this, 'sortables') ? $this->sortables : ['*'];
        if (!in_array($sort, $allowed) && !in_array('*', $allowed)) {
            return $query;
        }

        // Enforce valid direction
        if (!in_array($dir, ['asc', 'desc'])) {
            $dir = 'asc';
        }

        // Retrieve multi-column sorts mapping
        $multiColumnSorts = property_exists($this, 'multiColumnSorts') ? $this->multiColumnSorts : [];

        // Handle multi-column sorts
        if (array_key_exists($sort, $multiColumnSorts)) {
            // Apply each column in the multi-column sort
            foreach ($multiColumnSorts[$sort] as $multiColumnSort) {
                $query = $this->applySortableColumn($query, $multiColumnSort, $dir);
            }
            return $query;
        }

        // Handle single-column sort (apply directly)
        return $this->applySortableColumn($query, $sort, $dir);
    }

    /**
     * Applies sorting on a specific column.
     *
     * Handles two cases:
     * 1. Simple column: applies a standard orderBy
     * 2. Nested relationship (dot notation): performs necessary joins
     *    and applies sorting on the relationship's column
     *
     * For nested relationships:
     * - Parses dot notation (e.g., 'user.profile.city')
     * - Performs successive LEFT JOINs with unique aliases
     * - Avoids duplicate joins
     * - Applies final sort on the last relationship's column
     *
     * @param Builder $query Eloquent query builder instance
     * @param string $column Column name or relationship path (e.g., 'user.name')
     * @param string $dir Sort direction ('asc' or 'desc')
     *
     * @return Builder The modified query builder with applied sort
     */
    protected function applySortableColumn($query, string $column, string $dir)
    {
        // If it's a nested relationship (dot notation)
        if (str_contains($column, '.')) {
            $parts = explode('.', $column);
            $base = $this;
            $currentQuery = $query;
            $joinedPath = []; // To generate a unique alias

            // Go through all relationships except the last part
            while (count($parts) > 1) {
                $relation = array_shift($parts);

                // Ensure the relation method exists, otherwise return the query unmodified
                if (!method_exists($base, $relation)) {
                    return $query;
                }

                // Get the relation instance
                $relationQuery = $base->$relation();
                $related = $relationQuery->getRelated();
                $table = $related->getTable();

                // Generate a unique alias for the relation join
                $aliasPath = array_merge($joinedPath, [$relation]);
                $alias = implode('_', $aliasPath);
                $joinedPath = $aliasPath;

                // Check if join already exists
                $alreadyJoined = collect($currentQuery->getQuery()->joins ?? [])
                    ->pluck('table')
                    ->contains("{$table} as {$alias}");

                if (!$alreadyJoined) {

                    $foreignKey = $relationQuery->getQualifiedForeignKeyName();
                    $ownerKey = $relationQuery->getQualifiedOwnerKeyName();
                    $ownerKeyOnAlias = str_replace($related->getTable() . '.', $alias . '.', $ownerKey);

                    $currentQuery->leftJoin("{$table} as {$alias}", $foreignKey, '=', $ownerKeyOnAlias);
                }

                // Move down to the next relationship
                $base = $related;
            }

            // The last part is the actual column
            $col = array_shift($parts);

            // Final sort on the deepest alias
            return $currentQuery->orderBy("{$alias}.{$col}", $dir);
        }

        // Otherwise, simple sort
        return $query->orderBy($column, $dir);
    }
}

<?php

if (!function_exists('filterUrl')) {
    function filterUrl(array $newFilters = [])
    {
        $currentFilters = request()->get('filter', []);
        $mergedFilters = array_merge_recursive($currentFilters, $newFilters);

        // Remove empty values
        $mergedFilters = array_filter($mergedFilters, function($operators) {
            if (!is_array($operators)) return false;
            return array_filter($operators, fn($value) => !empty($value));
        });

        $query = request()->except(['filter']);

        if (!empty($mergedFilters)) {
            $query['filter'] = $mergedFilters;
        }

        return request()->url() . (count($query) ? '?' . http_build_query($query) : '');
    }
}

if (!function_exists('isFiltered')) {
    function isFiltered(string $field, ?string $operator = null): bool
    {
        $filters = request()->get('filter', []);
        if (!isset($filters[$field]) || !is_array($filters[$field])) {
            return false;
        }
        if ($operator === null) {
            return !empty(array_filter($filters[$field]));
        }
        return isset($filters[$field][$operator]) && !empty($filters[$field][$operator]);
    }
}

if (!function_exists('filterValue')) {
    function filterValue(string $field, ?string $operator = null)
    {
        $filters = request()->get('filter', []);
        if (!isset($filters[$field]) || !is_array($filters[$field])) {
            return null;
        }
        if ($operator === null) {
            // Return first non-empty value
            foreach ($filters[$field] as $op => $val) {
                if (!empty($val)) return $val;
            }
            return null;
        }
        return $filters[$field][$operator] ?? null;
    }
}

if (!function_exists('clearFilterUrl')) {
    function clearFilterUrl(string $field, ?string $operator = null)
    {
        $filters = request()->get('filter', []);
        if ($operator === null) {
            unset($filters[$field]);
        } else {
            unset($filters[$field][$operator]);
            if (empty($filters[$field])) {
                unset($filters[$field]);
            }
        }

        $query = request()->except(['filter']);

        if (!empty($filters)) {
            $query['filter'] = $filters;
        }

        return request()->url() . (count($query) ? '?' . http_build_query($query) : '');
    }
}

if (!function_exists('clearAllFiltersUrl')) {
    function clearAllFiltersUrl()
    {
        $query = request()->except(['filter']);
        return request()->url() . (count($query) ? '?' . http_build_query($query) : '');
    }
}
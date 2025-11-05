<?php

if (!function_exists('sortableUrl')) {

    function sortableUrl(string $field, array $cycle = ['asc', 'desc', null])
    {

        $currentSort = request()->get('sort');
        $currentDir = strtolower(request()->get('direction', 'asc'));

        $nextIndex = 0;
        if ($currentSort === $field) {
            $currentIndex = array_search($currentDir, $cycle, true);
            if ($currentIndex === false) {
                $currentIndex = 0;
            }
            $nextIndex = ($currentIndex + 1) % count($cycle);
        }

        $query = request()->except(['sort', 'direction']);

        $nextDir = $cycle[$nextIndex];
        if (in_array($nextDir, ['asc', 'desc'])) {
            $query['sort'] = $field;
            $query['direction'] = $nextDir;
        }

        return request()->url() . (count($query) ? '?' . http_build_query($query) : '');
    }
}

if (!function_exists('isSorted')) {
    function isSorted(string $field, ?string $direction): bool
    {
        $currentSort = request()->get('sort');
        $currentDir = strtolower(request()->get('direction', 'asc'));

        if ($currentSort === $field) {
            return $direction === null || $currentDir === strtolower($direction);
        }

        return false;
    }
}

if (!function_exists('sortState')) {
    function sortState(string $field): ?string
    {
        $currentSort = request()->get('sort');
        $currentDir = strtolower(request()->get('direction', 'asc'));

        if ($currentSort === $field) {
            return in_array($currentDir, ['asc', 'desc']) ? $currentDir : null;
        }

        return null;
    }
}

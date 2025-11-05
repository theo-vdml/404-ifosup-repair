<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CleanFilters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $originalQueryString = $request->getQueryString();

        $filters = $request->input('filter', []);

        if (!empty($filters)) {
            $cleanedFilters = [];

            foreach ($filters as $field => $operators) {
                if (is_array($operators)) {
                    $cleanedOps = array_filter($operators, fn($value) => !empty($value) && $value !== null);
                    if (!empty($cleanedOps)) {
                        $cleanedFilters[$field] = $cleanedOps;
                    }
                }
            }

            $request->merge(['filter' => $cleanedFilters]);
        }

        return $next($request);
    }
}

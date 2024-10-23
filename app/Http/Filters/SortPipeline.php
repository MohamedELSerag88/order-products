<?php


namespace App\Http\Filters;

use Closure;

class SortPipeline
{
    public function handle($request, Closure $next)
    {
        return $next($request)->orderBy(request()->get('sort_key', 'created_at'), request()->get('sort_type', 'DESC') );
    }
}

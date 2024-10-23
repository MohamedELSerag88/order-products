<?php


namespace App\Http\Filters;

use Closure;

class RangePipeline
{
    public function handle($request, Closure $next)
    {
        if(request()->get('range_key') && request()->get('range_values') && is_array(request()->get('range_values'))) {
            $key = request()->get('range_key');
            $values = request()->get('range_values');
            return $next($request)->whereBetween($key,  $values );
        }
        return $next($request);
    }
}

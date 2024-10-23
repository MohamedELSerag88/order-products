<?php


namespace App\Http\Filters;

use Carbon\Carbon;
use Closure;

class DatePipeline
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('date')) {
            return $next($request);
        }
        $startOfTheDay = Carbon::createFromDate(request()->date)->startOfDay();
        $endOfTheDay = Carbon::createFromDate(request()->date)->endOfDay();
        return $next($request)->whereBetween('created_at', [$startOfTheDay, $endOfTheDay]);
    }
}

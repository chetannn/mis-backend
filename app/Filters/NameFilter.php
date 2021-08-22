<?php

namespace App\Filters;

use App\Filters\Contracts\FilterInterface;

class NameFilter implements FilterInterface
{
    public function process($query, \Closure $next)
    {
        if(request()->has('name_en')) {
            $query->where('name_en', request()->get('name_en'));
        }

        return $next($query);
    }
}

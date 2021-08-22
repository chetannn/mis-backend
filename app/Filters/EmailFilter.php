<?php

namespace App\Filters;

use App\Filters\Contracts\FilterInterface;

class EmailFilter implements FilterInterface
{

    public function process($query, \Closure $next)
    {
        if(request()->has('email')) {
            $query->where('email', request()->get('email'));
        }

        return $next($query);
    }
}

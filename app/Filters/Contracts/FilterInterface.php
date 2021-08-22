<?php

namespace App\Filters\Contracts;

interface FilterInterface
{
    public function process($query, \Closure $next);
}

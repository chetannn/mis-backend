<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\NameFilter;
use App\Http\Requests\CountryRequest;
use App\Models\Country;

class CountryController extends CrudController
{

    public function model() : string
    {
        return Country::class;
    }

    public function formRequest(): string
    {
        return CountryRequest::class;
    }

    public function registeredFilters() : array
    {
        return [
            NameFilter::class
        ];
    }

}

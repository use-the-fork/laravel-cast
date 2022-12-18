<?php

namespace UseTheFork\LaravelCast\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \UseTheFork\LaravelCast\LaravelCast
 */
class LaravelCast extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \UseTheFork\LaravelCast\Cast::class;
    }
}

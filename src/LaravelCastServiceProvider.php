<?php

namespace UseTheFork\LaravelCast;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use UseTheFork\LaravelCast\Commands\LaravelCastCommand;

class LaravelCastServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name("laravel-cast");
    }
}

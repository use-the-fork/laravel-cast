<?php

namespace UseTheFork\LaravelCast\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use UseTheFork\LaravelCast\LaravelCastServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [LaravelCastServiceProvider::class];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}

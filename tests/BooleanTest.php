<?php

use UseTheFork\LaravelCast\Cast;

it(' can handle true values', function ($value) {
    expect(Cast::boolean($value))->toBeTrue();
})->with([true, 1, 'true', '1']);

it(' can handle false values', function ($value) {
    expect(Cast::boolean($value))->toBeFalse();
})->with([false, 0, 'false', '0', null]);

<?php

use Carbon\CarbonInterface;
use UseTheFork\LaravelCast\Cast;

it(' can handle date values', function ($input, $expected, $format) {
    ray(Cast::date($input, $format));
    expect(Cast::date($input, $format) == $expected)->toBeTrue();
})->with([
    ['2022-01-01', '2022-01-01', 'Y-m-d'],
    ['01/01/2022', '2022-01-01', 'Y-m-d'],
    ['2022/01/01', '2022-01-01', 'Y-m-d'],
    ['2022-01-01T01:23:45.678-05:00', '2022-01-01', 'Y-m-d'],
]);

it(' converts dates to Carbon', function ($input) {
    expect(Cast::date($input) instanceof CarbonInterface)->toBeTrue();
})->with([
    '2022-01-01',
    '01/01/2022',
    '2022/01/01',
    '2022-01-01T01:23:45.678-05:00',
]);

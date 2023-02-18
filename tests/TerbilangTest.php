<?php

namespace Riskihajar\Terbilang\Tests;

use Riskihajar\Terbilang\Terbilang;

it('has make method', function () {
    expect(method_exists(Terbilang::class, 'make'))->toBeTrue();
});

it('has distance method', function () {
    expect(method_exists(Terbilang::class, 'distance'))->toBeTrue();
});

it('has date method', function () {
    expect(method_exists(Terbilang::class, 'date'))->toBeTrue();
});

it('has time method', function () {
    expect(method_exists(Terbilang::class, 'time'))->toBeTrue();
});

it('has datetime method', function () {
    expect(method_exists(Terbilang::class, 'datetime'))->toBeTrue();
});

it('has largeNumber method', function () {
    expect(method_exists(Terbilang::class, 'largeNumber'))->toBeTrue();
});

it('has roman method', function () {
    expect(method_exists(Terbilang::class, 'roman'))->toBeTrue();
});

<?php

namespace Riskihajar\Terbilang\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Exceptions\InvalidNumber;
use Riskihajar\Terbilang\NumberToWords;

it('has make method', function () {
    $this->assertTrue(method_exists(NumberToWords::class, 'make'));
});

it('throw InvalidNumber if parameter is not a number', function () {
    (new NumberToWords)->make('Rp 1000,-');
})->throws(InvalidNumber::class);

it('throw InvalidNumber if number exceed from PHP_INT_MAX', function () {
    (new NumberToWords)->make(PHP_INT_MAX);
})->throws(InvalidNumber::class);

it('can convert number to words', function () {
    $this->assertEquals(
        'one million',
        (new NumberToWords)->make(1_000_000),
    );
    $this->assertEquals(
        'ten thousand',
        (new NumberToWords)->make(10_000),
    );
});

it('can use language', function () {
    Config::set('terbilang.locale', 'id');

    $this->assertEquals(
        'satu juta',
        (new NumberToWords)->make(1_000_000),
    );
    $this->assertEquals(
        'sepuluh ribu',
        (new NumberToWords)->make(10_000),
    );
    $this->assertEquals(
        'seribu',
        (new NumberToWords)->make(1_000),
    );
});

it('allow use \Illuminate\Support\Str pipe like upper', function () {
    $this->assertEquals('TWO MILLION', (new NumberToWords)->make(2_000_000)->upper());
});

it('return instance of Stringable', function () {
    $this->assertTrue((new NumberToWords)->make(2_500) instanceof Stringable);
});

it('not return string type', function () {
    $this->assertFalse(gettype((new NumberToWords)->make(3_500)) === 'string');
});

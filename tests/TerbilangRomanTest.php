<?php

namespace Riskihajar\Terbilang\Tests;

use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Roman;
use Riskihajar\Terbilang\Terbilang;

it('invokeable', function () {
    $this->assertTrue(method_exists(Roman::class, '__invoke'));
});

it('can convert number to roman', function () {
    $this->assertEquals('MMXXIII', (new Terbilang)->roman(2023));
});

it('allow use \Illuminate\Support\Str pipe like lower', function () {
    $this->assertEquals('mmxxiii', (new Terbilang)->roman(2023)->lower());
});

it('return instance of Stringable', function () {
    $this->assertTrue((new Terbilang)->roman(1234) instanceof Stringable);
});

it('not return string type', function () {
    $this->assertFalse(gettype((new Terbilang)->roman(1234)) === 'string');
});

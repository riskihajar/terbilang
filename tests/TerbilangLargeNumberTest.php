<?php

namespace Riskihajar\Terbilang\Tests;

use Riskihajar\Terbilang\Terbilang;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\LargeNumber;
use Riskihajar\Terbilang\LargeNumber as TerbilangLargeNumber;

it('invokeable', function(){
    $this->assertTrue(method_exists(TerbilangLargeNumber::class, '__invoke'));
});

it('has default target (Million)', function(){
    $this->assertEquals('5M', (new Terbilang)->largeNumber(number: 5_000_000));
});

it('can convert number to large number short', function(){
    $this->assertEquals('1M', (new Terbilang)->largeNumber(number: 1_000_000, target: LargeNumber::Million));
});

it('allow use \Illuminate\Support\Str pipe like upper', function(){
    $this->assertEquals('1K', (new Terbilang)->largeNumber(number: 1_000, target: LargeNumber::Kilo)->upper());
});

it('return instance of Stringable', function(){
    $this->assertTrue((new Terbilang)->largeNumber(2_000) instanceof Stringable);
});

it('not return string type', function(){
    $this->assertFalse(gettype((new Terbilang)->largeNumber(3_000)) === 'string');
});

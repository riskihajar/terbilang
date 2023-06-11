<?php

namespace Riskihajar\Terbilang\Tests;

use Riskihajar\Terbilang\DateTime;

it('has date method', function () {
    expect(method_exists(DateTime::class, 'date'))->toBeTrue();
});

it('has time method', function () {
    expect(method_exists(DateTime::class, 'time'))->toBeTrue();
});

it('has datetime method', function () {
    expect(method_exists(DateTime::class, 'datetime'))->toBeTrue();
});

it('can convert date to word', function () {
    $date = \DateTime::createFromFormat('Y-m-d', '2023-02-01');
    $this->assertEquals('one february two thousand and twenty-three', (new DateTime)->date($date));
});

it('can convert time to word', function () {
    $time = \DateTime::createFromFormat('H:i:s', '09:30:45');
    $this->assertEquals('nine past thirty minutes fourty-five seconds', (new DateTime)->time($time));
});

it('can convert datetime to word', function () {
    $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-03-01 11:12:13');
    $this->assertEquals('one march two thousand and twenty-three at eleven past twelve minutes thirteen seconds am', (new DateTime)->datetime($datetime));
});

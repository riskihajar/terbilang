<?php

namespace Riskihajar\Terbilang\Tests;

use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Exceptions\InvalidNumber;
use Riskihajar\Terbilang\Roman;
use Riskihajar\Terbilang\Terbilang;

// ============================================================
// Return Type
// ============================================================

it('returns instance of Stringable', function () {
    expect((new Terbilang)->roman(1234))->toBeInstanceOf(Stringable::class);
});

it('does not return raw string type', function () {
    expect(gettype((new Terbilang)->roman(1234)))->not->toBe('string');
});

it('is invokeable', function () {
    expect(method_exists(Roman::class, '__invoke'))->toBeTrue();
});

it('allows Str pipe chaining like lower', function () {
    expect((new Terbilang)->roman(2023)->lower()->toString())->toBe('mmxxiii');
});

// ============================================================
// Basic conversions
// ============================================================

it('converts basic numbers to roman', function ($number, $expected) {
    expect((new Terbilang)->roman($number)->toString())->toBe($expected);
})->with([
    [1, 'I'],
    [2, 'II'],
    [3, 'III'],
    [4, 'IV'],
    [5, 'V'],
    [6, 'VI'],
    [7, 'VII'],
    [8, 'VIII'],
    [9, 'IX'],
    [10, 'X'],
]);

// ============================================================
// Subtractive notation
// ============================================================

it('uses subtractive notation correctly', function ($number, $expected) {
    expect((new Terbilang)->roman($number)->toString())->toBe($expected);
})->with([
    [4, 'IV'],
    [9, 'IX'],
    [14, 'XIV'],
    [40, 'XL'],
    [49, 'XLIX'],
    [90, 'XC'],
    [99, 'XCIX'],
    [400, 'CD'],
    [900, 'CM'],
    [944, 'CMXLIV'],
]);

// ============================================================
// Larger numbers
// ============================================================

it('converts larger numbers to roman', function ($number, $expected) {
    expect((new Terbilang)->roman($number)->toString())->toBe($expected);
})->with([
    [50, 'L'],
    [100, 'C'],
    [500, 'D'],
    [1000, 'M'],
    [1776, 'MDCCLXXVI'],
    [1945, 'MCMXLV'],
    [2023, 'MMXXIII'],
    [2024, 'MMXXIV'],
    [3999, 'MMMCMXCIX'],
]);

// ============================================================
// Boundary values
// ============================================================

it('converts minimum valid value 1', function () {
    expect((new Terbilang)->roman(1)->toString())->toBe('I');
});

it('converts maximum valid value 3999', function () {
    expect((new Terbilang)->roman(3999)->toString())->toBe('MMMCMXCIX');
});

// ============================================================
// Invalid input (validation from bug fix)
// ============================================================

it('throws exception for zero', function () {
    (new Terbilang)->roman(0);
})->throws(InvalidNumber::class, 'Roman numerals only support numbers between 1 and 3999');

it('throws exception for negative numbers', function () {
    (new Terbilang)->roman(-1);
})->throws(InvalidNumber::class, 'Roman numerals only support numbers between 1 and 3999');

it('throws exception for numbers above 3999', function () {
    (new Terbilang)->roman(4000);
})->throws(InvalidNumber::class, 'Roman numerals only support numbers between 1 and 3999');

it('throws exception for very large numbers', function () {
    (new Terbilang)->roman(10000);
})->throws(InvalidNumber::class, 'Roman numerals only support numbers between 1 and 3999');

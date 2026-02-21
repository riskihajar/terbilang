<?php

namespace Riskihajar\Terbilang\Tests;

use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Exceptions\InvalidNumber;
use Riskihajar\Terbilang\NumberToWords;

beforeEach(function () {
    config()->set('terbilang.use_intl', false);
    config()->set('terbilang.locale', 'en');
});

// ============================================================
// Return Type
// ============================================================

it('returns instance of Stringable', function () {
    expect((new NumberToWords)->make(100))->toBeInstanceOf(Stringable::class);
});

it('does not return raw string type', function () {
    expect(gettype((new NumberToWords)->make(100)))->not->toBe('string');
});

it('allows Str pipe chaining like upper', function () {
    expect((new NumberToWords)->make(2_000_000)->upper()->toString())->toBe('TWO MILLION');
});

it('allows Str pipe chaining like lower', function () {
    expect((new NumberToWords)->make(100)->lower()->toString())->toBe('one hundred');
});

// ============================================================
// Validation
// ============================================================

it('throws InvalidNumber for non-numeric string', function () {
    (new NumberToWords)->make('Rp 1000,-');
})->throws(InvalidNumber::class);

it('throws InvalidNumber for alphabetic input', function () {
    (new NumberToWords)->make('hello');
})->throws(InvalidNumber::class);

it('throws InvalidNumber for empty string', function () {
    (new NumberToWords)->make('');
})->throws(InvalidNumber::class);

it('throws InvalidNumber when number exceeds PHP_INT_MAX', function () {
    (new NumberToWords)->make(PHP_INT_MAX);
})->throws(InvalidNumber::class);

it('throws InvalidNumber for extreme negative number', function () {
    (new NumberToWords)->make(-PHP_INT_MAX);
})->throws(InvalidNumber::class);

// ============================================================
// Zero
// ============================================================

it('converts zero to words', function () {
    expect((new NumberToWords)->make(0)->toString())->toBe('zero');
});

it('converts string zero to words', function () {
    expect((new NumberToWords)->make('0')->toString())->toBe('zero');
});

// ============================================================
// Single digits (1-9)
// ============================================================

it('converts single digits to words', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [1, 'one'],
    [2, 'two'],
    [3, 'three'],
    [4, 'four'],
    [5, 'five'],
    [6, 'six'],
    [7, 'seven'],
    [8, 'eight'],
    [9, 'nine'],
]);

// ============================================================
// Teens (10-20)
// ============================================================

it('converts teens to words', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [10, 'ten'],
    [11, 'eleven'],
    [12, 'twelve'],
    [13, 'thirteen'],
    [14, 'fourteen'],
    [15, 'fifteen'],
    [16, 'sixteen'],
    [17, 'seventeen'],
    [18, 'eighteen'],
    [19, 'nineteen'],
    [20, 'twenty'],
]);

// ============================================================
// Tens boundary values (21-99)
// ============================================================

it('converts tens to words', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [21, 'twenty-one'],
    [30, 'thirty'],
    [40, 'forty'],
    [42, 'forty-two'],
    [50, 'fifty'],
    [60, 'sixty'],
    [70, 'seventy'],
    [80, 'eighty'],
    [90, 'ninety'],
    [99, 'ninety-nine'],
]);

// ============================================================
// Hundreds (100-999)
// ============================================================

it('converts hundreds to words', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [100, 'one hundred'],
    [101, 'one hundred and one'],
    [110, 'one hundred and ten'],
    [150, 'one hundred and fifty'],
    [199, 'one hundred and ninety-nine'],
    [200, 'two hundred'],
    [500, 'five hundred'],
    [999, 'nine hundred and ninety-nine'],
]);

// ============================================================
// Thousands (1,000 - 999,999)
// ============================================================

it('converts thousands to words', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [1000, 'one thousand'],
    [1001, 'one thousand and one'],
    [1010, 'one thousand and ten'],
    [1100, 'one thousand, one hundred'],
    [2500, 'two thousand, five hundred'],
    [10000, 'ten thousand'],
    [10001, 'ten thousand and one'],
    [100000, 'one hundred thousand'],
    [999999, 'nine hundred and ninety-nine thousand, nine hundred and ninety-nine'],
]);

// ============================================================
// Millions and above
// ============================================================

it('converts millions and above to words', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [1000000, 'one million'],
    [1000001, 'one million and one'],
    [2500000, 'two million, five hundred thousand'],
    [1000000000, 'one billion'],
    [1000000000000, 'one trillion'],
]);

// ============================================================
// Negative numbers
// ============================================================

it('converts negative numbers', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [-1, 'negative one'],
    [-5, 'negative five'],
    [-21, 'negative twenty-one'],
    [-100, 'negative one hundred'],
    [-1000, 'negative one thousand'],
    [-1000000, 'negative one million'],
]);

// ============================================================
// Decimal numbers (digit-by-digit after point)
// ============================================================

it('converts decimal numbers', function ($number, $expected) {
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [0.5, 'zero point five'],
    [1.5, 'one point five'],
    [3.14, 'three point one four'],
    [100.99, 'one hundred point nine nine'],
]);

// ============================================================
// String number input
// ============================================================

it('accepts string number input', function ($input, $expected) {
    expect((new NumberToWords)->make($input)->toString())->toBe($expected);
})->with([
    ['42', 'forty-two'],
    ['1000', 'one thousand'],
    ['100', 'one hundred'],
]);

// ============================================================
// Indonesian locale
// ============================================================

it('converts basic numbers in Indonesian', function ($number, $expected) {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [0, 'nol'],
    [1, 'satu'],
    [5, 'lima'],
    [10, 'sepuluh'],
    [11, 'sebelas'],
    [12, 'dua belas'],
    [20, 'dua puluh'],
    [21, 'dua puluh satu'],
    [99, 'sembilan puluh sembilan'],
]);

it('uses Indonesian se prefix for seratus', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(100)->toString())->toBe('seratus');
});

it('does not use se prefix for dua ratus in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(200)->toString())->toBe('dua ratus');
});

it('uses Indonesian se prefix for seribu', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(1000)->toString())->toBe('seribu');
});

it('does not use se prefix for dua ribu in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(2000)->toString())->toBe('dua ribu');
});

it('does not use se prefix for satu juta in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(1_000_000)->toString())->toBe('satu juta');
});

it('converts complex Indonesian numbers', function ($number, $expected) {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [150, 'seratus lima puluh'],
    [1500, 'seribu lima ratus'],
    [10000, 'sepuluh ribu'],
    [21500, 'dua puluh satu ribu lima ratus'],
    [1000000000, 'satu miliar'],
]);

it('converts negative numbers in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(-100)->toString())->toBe('negatif seratus');
    expect((new NumberToWords)->make(-1000)->toString())->toBe('negatif seribu');
});

it('converts decimal numbers in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    expect((new NumberToWords)->make(1.5)->toString())->toBe('satu titik lima');
});

// ============================================================
// Portuguese locale
// ============================================================

it('converts basic numbers in Portuguese', function ($number, $expected) {
    config()->set('terbilang.locale', 'pt');
    expect((new NumberToWords)->make($number)->toString())->toBe($expected);
})->with([
    [0, 'zero'],
    [1, 'um'],
    [5, 'cinco'],
    [10, 'dez'],
    [21, 'vinte-um'],
    [50, 'cinquenta'],
]);

it('converts negative numbers in Portuguese', function () {
    config()->set('terbilang.locale', 'pt');
    expect((new NumberToWords)->make(-5)->toString())->toBe('negativo cinco');
});

it('converts decimal numbers in Portuguese', function () {
    config()->set('terbilang.locale', 'pt');
    expect((new NumberToWords)->make(1.5)->toString())->toBe('um ponto cinco');
});

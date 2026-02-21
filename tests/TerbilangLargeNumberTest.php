<?php

namespace Riskihajar\Terbilang\Tests;

use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\LargeNumber;
use Riskihajar\Terbilang\LargeNumber as TerbilangLargeNumber;
use Riskihajar\Terbilang\Terbilang;

beforeEach(function () {
    config()->set('terbilang.use_intl', false);
    config()->set('terbilang.locale', 'en');
});

// ============================================================
// Return Type
// ============================================================

it('returns instance of Stringable', function () {
    expect((new Terbilang)->largeNumber(5_000_000))->toBeInstanceOf(Stringable::class);
});

it('does not return raw string type', function () {
    expect(gettype((new Terbilang)->largeNumber(5_000_000)))->not->toBe('string');
});

it('is invokeable', function () {
    expect(method_exists(TerbilangLargeNumber::class, '__invoke'))->toBeTrue();
});

it('allows Str pipe chaining like upper', function () {
    expect((new Terbilang)->largeNumber(1_000, target: LargeNumber::Kilo)->upper()->toString())->toBe('1K');
});

// ============================================================
// Auto-detect target scale
// ============================================================

it('auto-detects kilo for thousands', function () {
    expect((new Terbilang)->largeNumber(5_000)->toString())->toBe('5k');
});

it('auto-detects million', function () {
    expect((new Terbilang)->largeNumber(5_000_000)->toString())->toBe('5M');
});

it('auto-detects billion', function () {
    expect((new Terbilang)->largeNumber(2_500_000_000)->toString())->toBe('2.5B');
});

it('auto-detects trillion', function () {
    expect((new Terbilang)->largeNumber(1_000_000_000_000)->toString())->toBe('1T');
});

it('auto-detects with fractional results', function () {
    expect((new Terbilang)->largeNumber(1_500_000)->toString())->toBe('1.5M');
});

it('auto-detects with precision rounding', function () {
    expect((new Terbilang)->largeNumber(1_234_567)->toString())->toBe('1.23M');
});

// ============================================================
// Explicit target scale
// ============================================================

it('uses explicit Kilo target', function () {
    expect((new Terbilang)->largeNumber(1_000, target: LargeNumber::Kilo)->toString())->toBe('1k');
});

it('uses explicit Million target', function () {
    expect((new Terbilang)->largeNumber(1_000_000, target: LargeNumber::Million)->toString())->toBe('1M');
});

it('uses explicit Billion target', function () {
    expect((new Terbilang)->largeNumber(1_000_000_000, target: LargeNumber::Billion)->toString())->toBe('1B');
});

it('uses explicit Trillion target', function () {
    expect((new Terbilang)->largeNumber(1_000_000_000_000, target: LargeNumber::Trillion)->toString())->toBe('1T');
});

it('can force Kilo target on a million value', function () {
    expect((new Terbilang)->largeNumber(1_000_000, target: LargeNumber::Kilo)->toString())->toBe('1000k');
});

it('can force Million target on a thousand value', function () {
    expect((new Terbilang)->largeNumber(500_000, target: LargeNumber::Million)->toString())->toBe('0.5M');
});

// ============================================================
// Zero and small numbers (edge cases from bug fix)
// ============================================================

it('returns zero as-is when auto-detecting', function () {
    expect((new Terbilang)->largeNumber(0)->toString())->toBe('0');
});

it('returns small numbers as-is when auto-detecting', function () {
    expect((new Terbilang)->largeNumber(500)->toString())->toBe('500');
});

it('returns 999 as-is when auto-detecting', function () {
    expect((new Terbilang)->largeNumber(999)->toString())->toBe('999');
});

// ============================================================
// Negative numbers (edge case from bug fix)
// ============================================================

it('handles negative thousands', function () {
    expect((new Terbilang)->largeNumber(-5_000)->toString())->toBe('-5k');
});

it('handles negative millions', function () {
    expect((new Terbilang)->largeNumber(-2_500_000)->toString())->toBe('-2.5M');
});

it('handles negative small numbers as-is', function () {
    expect((new Terbilang)->largeNumber(-500)->toString())->toBe('-500');
});

// ============================================================
// Indonesian locale
// ============================================================

it('uses Indonesian abbreviations', function ($number, $expected) {
    config()->set('terbilang.locale', 'id');
    expect((new Terbilang)->largeNumber($number)->toString())->toBe($expected);
})->with([
    [5_000, '5k'],
    [1_000_000, '1jt'],
    [5_000_000, '5jt'],
    [1_500_000, '1.5jt'],
    [1_000_000_000, '1M'],
    [2_500_000_000, '2.5M'],
    [1_000_000_000_000, '1T'],
]);

// ============================================================
// Portuguese locale (fixed key)
// ============================================================

it('uses Portuguese abbreviations after key fix', function ($number, $expected) {
    config()->set('terbilang.locale', 'pt');
    expect((new Terbilang)->largeNumber($number)->toString())->toBe($expected);
})->with([
    [5_000, '5k'],
    [1_000_000, '1M'],
    [1_000_000_000, '1B'],
    [1_000_000_000_000, '1T'],
]);

// ============================================================
// Deprecated short() method
// ============================================================

it('short method still works as backward compatibility', function () {
    expect((new Terbilang)->short(5_000_000)->toString())->toBe('5M');
});

it('short method accepts string target', function () {
    expect((new Terbilang)->short(1_000_000, 'million')->toString())->toBe('1M');
});

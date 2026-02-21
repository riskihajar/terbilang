<?php

namespace Riskihajar\Terbilang\Tests;

use Carbon\Carbon;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Terbilang;

beforeEach(function () {
    config()->set('terbilang.use_intl', false);
    config()->set('terbilang.locale', 'en');
});

// ============================================================
// Method existence (backward compat)
// ============================================================

it('has make method', function () {
    expect(method_exists(Terbilang::class, 'make'))->toBeTrue();
});

it('has distance method', function () {
    expect(method_exists(Terbilang::class, 'distance'))->toBeTrue();
});

it('has period method to support old version', function () {
    expect(method_exists(Terbilang::class, 'period'))->toBeTrue();
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

it('has short method to support old version', function () {
    expect(method_exists(Terbilang::class, 'short'))->toBeTrue();
});

it('has roman method', function () {
    expect(method_exists(Terbilang::class, 'roman'))->toBeTrue();
});

// ============================================================
// All methods return Stringable
// ============================================================

it('make returns Stringable', function () {
    expect((new Terbilang)->make(100))->toBeInstanceOf(Stringable::class);
});

it('date returns Stringable', function () {
    expect((new Terbilang)->date('2023-01-01'))->toBeInstanceOf(Stringable::class);
});

it('time returns Stringable', function () {
    expect((new Terbilang)->time('12:00:00'))->toBeInstanceOf(Stringable::class);
});

it('datetime returns Stringable', function () {
    expect((new Terbilang)->datetime('2023-01-01 12:00:00'))->toBeInstanceOf(Stringable::class);
});

it('largeNumber returns Stringable', function () {
    expect((new Terbilang)->largeNumber(5_000_000))->toBeInstanceOf(Stringable::class);
});

it('roman returns Stringable', function () {
    expect((new Terbilang)->roman(100))->toBeInstanceOf(Stringable::class);
});

it('distance returns Stringable', function () {
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 2);
    expect((new Terbilang)->distance($start, $end))->toBeInstanceOf(Stringable::class);
});

// ============================================================
// make() behavioral tests
// ============================================================

it('make converts number to words', function () {
    expect((new Terbilang)->make(1000)->toString())->toBe('one thousand');
});

it('make applies prefix when provided', function () {
    $result = (new Terbilang)->make(1000, prefix: 'valued')->toString();
    expect($result)->toStartWith('valued');
    expect($result)->toContain('one thousand');
});

it('make applies suffix when provided', function () {
    $result = (new Terbilang)->make(1000, suffix: 'dollars')->toString();
    expect($result)->toEndWith('dollars');
    expect($result)->toContain('one thousand');
});

it('make applies both prefix and suffix', function () {
    $result = (new Terbilang)->make(1000, prefix: 'valued', suffix: 'rupiah')->toString();
    expect($result)->toStartWith('valued');
    expect($result)->toEndWith('rupiah');
});

it('make uses locale default prefix and suffix from config', function () {
    // Default prefix/suffix in en is empty string, so no change
    $result = (new Terbilang)->make(100)->toString();
    expect($result)->toBe('one hundred');
});

// ============================================================
// Facade-level integration tests
// ============================================================

it('date method delegates to DateTime class', function () {
    $result = (new Terbilang)->date('2023-08-17')->toString();
    expect($result)->toBe('seventeen august two thousand and twenty-three');
});

it('time method delegates to DateTime class', function () {
    $result = (new Terbilang)->time('14:30:00')->toString();
    expect($result)->toContain('fourteen');
    expect($result)->toContain('thirty');
});

it('roman method delegates to Roman class', function () {
    expect((new Terbilang)->roman(2024)->toString())->toBe('MMXXIV');
});

it('largeNumber method delegates to LargeNumber class', function () {
    expect((new Terbilang)->largeNumber(5_000_000)->toString())->toBe('5M');
});

// ============================================================
// Locale switching
// ============================================================

it('respects locale config for make', function () {
    config()->set('terbilang.locale', 'id');
    expect((new Terbilang)->make(1000)->toString())->toBe('seribu');
});

it('respects locale config for date', function () {
    config()->set('terbilang.locale', 'id');
    $result = (new Terbilang)->date('2023-08-17')->toString();
    expect($result)->toContain('agustus');
});

it('respects locale config for largeNumber', function () {
    config()->set('terbilang.locale', 'id');
    expect((new Terbilang)->largeNumber(5_000_000)->toString())->toBe('5jt');
});

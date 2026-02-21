<?php

namespace Riskihajar\Terbilang\Tests;

use Carbon\Carbon;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\DistanceDate as Enum;
use Riskihajar\Terbilang\Terbilang;

beforeEach(function () {
    config()->set('terbilang.use_intl', false);
    config()->set('terbilang.locale', 'en');
});

// ============================================================
// Return Type
// ============================================================

it('returns Stringable from distance', function () {
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 2);
    $result = (new Terbilang)->distance($start, $end);
    expect($result)->toBeInstanceOf(Stringable::class);
});

// ============================================================
// Day type (default)
// ============================================================

it('calculates distance in days by default', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 11);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('10 days');
});

it('calculates distance of 1 day', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 2);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('1 days');
});

it('calculates distance of 0 days for same date', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    $start = Carbon::create(2023, 6, 15, 10, 0, 0);
    $end = Carbon::create(2023, 6, 15, 18, 0, 0);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('0 days');
});

// ============================================================
// Year type
// ============================================================

it('calculates distance in years', function () {
    config()->set('terbilang.distance.type', Enum::Year);
    $start = Carbon::create(2020, 1, 1);
    $end = Carbon::create(2023, 6, 15);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('3 years');
});

// ============================================================
// Month type
// ============================================================

it('calculates distance in months', function () {
    config()->set('terbilang.distance.type', Enum::Month);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 4, 1);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('3 months');
});

// ============================================================
// Hour type
// ============================================================

it('calculates distance in hours', function () {
    config()->set('terbilang.distance.type', Enum::Hour);
    $start = Carbon::create(2023, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 1, 2, 12, 0, 0);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('36 hours');
});

// ============================================================
// Minute type
// ============================================================

it('calculates distance in minutes', function () {
    config()->set('terbilang.distance.type', Enum::Minute);
    $start = Carbon::create(2023, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 1, 1, 2, 30, 0);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('150 minutes');
});

// ============================================================
// Second type
// ============================================================

it('calculates distance in seconds', function () {
    config()->set('terbilang.distance.type', Enum::Second);
    $start = Carbon::create(2023, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 1, 1, 0, 1, 30);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('90 seconds');
});

// ============================================================
// Full type
// ============================================================

it('calculates full distance with all components', function () {
    config()->set('terbilang.distance.type', Enum::Full);
    config()->set('terbilang.distance.hide_zero_value', false);
    $start = Carbon::create(2020, 3, 10, 8, 30, 15);
    $end = Carbon::create(2023, 6, 15, 14, 45, 30);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toContain('years');
    expect($result)->toContain('months');
    expect($result)->toContain('days');
    expect($result)->toContain('hours');
    expect($result)->toContain('minutes');
    expect($result)->toContain('seconds');
});

it('hides zero values in full mode when configured', function () {
    config()->set('terbilang.distance.type', Enum::Full);
    config()->set('terbilang.distance.hide_zero_value', true);
    // Exactly 2 years apart — month, day, hour, minute, second are all 0
    $start = Carbon::create(2021, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 1, 1, 0, 0, 0);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toContain('2 years');
    expect($result)->not->toContain('months');
    expect($result)->not->toContain('days');
    expect($result)->not->toContain('hours');
    expect($result)->not->toContain('minutes');
    expect($result)->not->toContain('seconds');
});

// ============================================================
// Show flags (config key fix validation)
// ============================================================

it('respects show flags to hide specific components', function () {
    config()->set('terbilang.distance.type', Enum::Full);
    config()->set('terbilang.distance.hide_zero_value', false);
    config()->set('terbilang.distance.show.year', true);
    config()->set('terbilang.distance.show.month', false);
    config()->set('terbilang.distance.show.day', true);
    config()->set('terbilang.distance.show.hour', false);
    config()->set('terbilang.distance.show.minute', false);
    config()->set('terbilang.distance.show.second', false);

    $start = Carbon::create(2020, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 6, 15, 14, 45, 30);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toContain('years');
    expect($result)->toContain('days');
    expect($result)->not->toContain('months');
    expect($result)->not->toContain('hours');
    expect($result)->not->toContain('minutes');
    expect($result)->not->toContain('seconds');
});

// ============================================================
// Terbilang mode (spell out numbers)
// ============================================================

it('spells out numbers when terbilang mode enabled', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    config()->set('terbilang.distance.terbilang', true);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 11);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('ten days');
});

it('spells out numbers in full mode when terbilang enabled', function () {
    config()->set('terbilang.distance.type', Enum::Full);
    config()->set('terbilang.distance.hide_zero_value', true);
    config()->set('terbilang.distance.terbilang', true);
    $start = Carbon::create(2021, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 1, 1, 0, 0, 0);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toContain('two');
    expect($result)->toContain('years');
});

// ============================================================
// Indonesian locale
// ============================================================

it('uses Indonesian labels for distance', function () {
    config()->set('terbilang.locale', 'id');
    config()->set('terbilang.distance.type', Enum::Day);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 11);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('10 hari');
});

it('uses Indonesian labels for full distance', function () {
    config()->set('terbilang.locale', 'id');
    config()->set('terbilang.distance.type', Enum::Full);
    config()->set('terbilang.distance.hide_zero_value', true);
    $start = Carbon::create(2021, 1, 1, 0, 0, 0);
    $end = Carbon::create(2023, 3, 15, 0, 0, 0);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toContain('tahun');
    expect($result)->toContain('bulan');
    expect($result)->toContain('hari');
});

it('spells out numbers in Indonesian distance', function () {
    config()->set('terbilang.locale', 'id');
    config()->set('terbilang.distance.type', Enum::Day);
    config()->set('terbilang.distance.terbilang', true);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 4);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('tiga hari');
});

// ============================================================
// Portuguese locale
// ============================================================

it('uses Portuguese labels for distance', function () {
    config()->set('terbilang.locale', 'pt');
    config()->set('terbilang.distance.type', Enum::Day);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 6);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('5 dias');
});

// ============================================================
// Custom config override
// ============================================================

it('allows custom separator in distance output', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    config()->set('terbilang.distance.separator', '-');
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 6);
    $result = (new Terbilang)->distance($start, $end)->toString();
    expect($result)->toBe('5-days');
});

// ============================================================
// Deprecated period() method
// ============================================================

it('period method still works as backward compatibility', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    $start = Carbon::create(2023, 1, 1);
    $end = Carbon::create(2023, 1, 11);
    $result = (new Terbilang)->period($start, $end)->toString();
    expect($result)->toBe('10 days');
});

it('period method accepts string dates', function () {
    config()->set('terbilang.distance.type', Enum::Day);
    $result = (new Terbilang)->period('2023-01-01', '2023-01-11')->toString();
    expect($result)->toBe('10 days');
});

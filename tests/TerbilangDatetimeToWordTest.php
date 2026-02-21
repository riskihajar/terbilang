<?php

namespace Riskihajar\Terbilang\Tests;

use Carbon\Carbon;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\DateTime;

beforeEach(function () {
    config()->set('terbilang.use_intl', false);
    config()->set('terbilang.locale', 'en');
});

// ============================================================
// Return Type
// ============================================================

it('returns Stringable from date()', function () {
    $date = \DateTime::createFromFormat('Y-m-d', '2023-01-01');
    expect((new DateTime)->date($date))->toBeInstanceOf(Stringable::class);
});

it('returns Stringable from time()', function () {
    $time = \DateTime::createFromFormat('H:i:s', '12:00:00');
    expect((new DateTime)->time($time))->toBeInstanceOf(Stringable::class);
});

it('returns Stringable from datetime()', function () {
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:00:00');
    expect((new DateTime)->datetime($dt))->toBeInstanceOf(Stringable::class);
});

// ============================================================
// Date conversion - English
// ============================================================

it('converts date to words in English', function ($input, $expected) {
    $date = \DateTime::createFromFormat('Y-m-d', $input);
    expect((new DateTime)->date($date)->toString())->toBe($expected);
})->with([
    ['2023-02-01', 'one february two thousand and twenty-three'],
    ['2023-01-15', 'fifteen january two thousand and twenty-three'],
    ['2000-06-30', 'thirty june two thousand'],
    ['1999-12-31', 'thirty-one december one thousand, nine hundred and ninety-nine'],
]);

it('converts single digit day correctly', function () {
    $date = \DateTime::createFromFormat('Y-m-d', '2023-03-05');
    expect((new DateTime)->date($date)->toString())->toBe('five march two thousand and twenty-three');
});

it('converts all months correctly in English', function ($month, $monthName) {
    $date = \DateTime::createFromFormat('Y-m-d', "2023-{$month}-01");
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toContain($monthName);
})->with([
    ['01', 'january'],
    ['02', 'february'],
    ['03', 'march'],
    ['04', 'april'],
    ['05', 'may'],
    ['06', 'june'],
    ['07', 'july'],
    ['08', 'august'],
    ['09', 'september'],
    ['10', 'october'],
    ['11', 'november'],
    ['12', 'december'],
]);

// ============================================================
// Date conversion - Indonesian
// ============================================================

it('converts date to words in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $date = \DateTime::createFromFormat('Y-m-d', '2023-08-17');
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toContain('agustus');
});

it('converts November correctly in Indonesian after fix', function () {
    config()->set('terbilang.locale', 'id');
    $date = \DateTime::createFromFormat('Y-m-d', '2023-11-15');
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toContain('november');
    expect($result)->not->toContain('nopember');
});

// ============================================================
// Date - accepts different input types
// ============================================================

it('accepts Carbon instance for date', function () {
    $date = Carbon::create(2023, 5, 10);
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toBe('ten may two thousand and twenty-three');
});

it('accepts string input for date', function () {
    $result = (new DateTime)->date('2023-05-10')->toString();
    expect($result)->toBe('ten may two thousand and twenty-three');
});

it('accepts PHP DateTime for date', function () {
    $date = new \DateTime('2023-05-10');
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toBe('ten may two thousand and twenty-three');
});

// ============================================================
// Date - custom template
// ============================================================

it('uses custom date output template', function () {
    config()->set('terbilang.output.date', '{MONTH} {DAY}, {YEAR}');
    $date = \DateTime::createFromFormat('Y-m-d', '2023-07-04');
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toBe('july four, two thousand and twenty-three');
});

// ============================================================
// Time conversion - English
// ============================================================

it('converts time to words in English', function () {
    $time = \DateTime::createFromFormat('H:i:s', '09:30:45');
    expect((new DateTime)->time($time)->toString())->toBe('nine past thirty minutes forty-five seconds');
});

it('omits seconds when zero', function () {
    $time = \DateTime::createFromFormat('H:i:s', '14:20:00');
    $result = (new DateTime)->time($time)->toString();
    expect($result)->not->toContain('seconds');
});

it('converts midnight time', function () {
    $time = \DateTime::createFromFormat('H:i:s', '00:00:00');
    $result = (new DateTime)->time($time)->toString();
    expect($result)->toContain('zero');
});

it('accepts Carbon for time', function () {
    $time = Carbon::createFromTime(15, 45, 30);
    $result = (new DateTime)->time($time)->toString();
    expect($result)->toContain('fifteen');
    expect($result)->toContain('forty-five');
    expect($result)->toContain('thirty');
});

// ============================================================
// Time conversion - Indonesian
// ============================================================

it('converts time to words in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $time = \DateTime::createFromFormat('H:i:s', '09:30:45');
    $result = (new DateTime)->time($time)->toString();
    expect($result)->toContain('sembilan');
    expect($result)->toContain('lewat');
    expect($result)->toContain('tiga puluh');
    expect($result)->toContain('menit');
});

// ============================================================
// Datetime conversion - English
// ============================================================

it('converts datetime to words in English', function () {
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-03-01 11:12:13');
    expect((new DateTime)->datetime($dt)->toString())
        ->toBe('one march two thousand and twenty-three at eleven past twelve minutes thirteen seconds am');
});

it('converts PM datetime in English', function () {
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-06-15 15:30:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('pm');
    expect($result)->toContain('june');
});

it('converts AM datetime in English', function () {
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-06-15 09:30:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('am');
});

// ============================================================
// Datetime - Indonesian meridiem (pagi/siang/sore/malam)
// ============================================================

it('uses pagi for early morning in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-01 06:00:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('pagi');
});

it('uses siang for late morning in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-01 11:00:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('siang');
});

it('uses siang for noon in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:30:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('siang');
});

it('uses sore for afternoon in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-01 15:00:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('sore');
});

it('uses malam for night in Indonesian', function () {
    config()->set('terbilang.locale', 'id');
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-01 21:00:00');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('malam');
});

// ============================================================
// Datetime - accepts different input types
// ============================================================

it('accepts Carbon instance for datetime', function () {
    $dt = Carbon::create(2023, 7, 4, 14, 30, 0);
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('july');
    expect($result)->toContain('pm');
});

// ============================================================
// Portuguese locale
// ============================================================

it('converts date to words in Portuguese', function () {
    config()->set('terbilang.locale', 'pt');
    $date = \DateTime::createFromFormat('Y-m-d', '2023-03-15');
    $result = (new DateTime)->date($date)->toString();
    expect($result)->toContain('março');
});

it('converts time to words in Portuguese', function () {
    config()->set('terbilang.locale', 'pt');
    $time = \DateTime::createFromFormat('H:i:s', '09:30:45');
    $result = (new DateTime)->time($time)->toString();
    expect($result)->toContain('passado');
    expect($result)->toContain('minutos');
});

it('uses Portuguese dt-separator in datetime', function () {
    config()->set('terbilang.locale', 'pt');
    $dt = \DateTime::createFromFormat('Y-m-d H:i:s', '2023-03-01 11:12:13');
    $result = (new DateTime)->datetime($dt)->toString();
    expect($result)->toContain('em');
});

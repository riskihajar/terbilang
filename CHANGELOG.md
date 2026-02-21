# Changelog

All notable changes to `terbilang` will be documented in this file.

## 2.1.1 - 2026-02-21

### Fixed
- Fixed meridiem variable shadowing in `DateTime::datetime()` that broke Indonesian time-of-day labels (pagi/siang/sore/malam)
- Fixed config key mismatch in `DistanceDate` — code read `terbilang.period.show.*` instead of `terbilang.distance.show.*`, causing show flags to never work
- Fixed Portuguese translation key `short` → `large-number`, restoring large number abbreviation for pt locale
- Fixed English dictionary typo `fourty` → `forty`
- Fixed Indonesian month typo `Nopember` → `November`
- Fixed `LargeNumber` crash on zero (`log(0) = -INF`) and negative numbers (`log(-n) = NAN`)
- Fixed `Roman` silently returning empty string for 0, negative, or >3999 — now throws `InvalidNumber::invalidRomanRange()`
- Fixed double space in negative number output (`negative  one` → `negative one`) caused by trailing space in translation + extra prepend separator
- Fixed `DistanceDate` minute/second accumulation missing hours/minutes components (e.g. 2h30m was reported as 30 minutes instead of 150)
- Fixed `DistanceDate::type()` output having a leading separator (`-5-days` → `5-days`)
- Removed dead code in `DistanceDate::type()` (duplicate `$value` assignment for Year)

### Tests
- Comprehensive test rewrite: **34 → 271 tests** (307 assertions)
- Added `TerbilangDistanceDateTest` (previously zero coverage)
- Full coverage for: zero, negatives, decimals, boundary values (0–99, 100s, 1000s, millions)
- All 3 locales tested (en, id, pt) across all features
- Indonesian meridiem tests (pagi/siang/sore/malam)
- Roman numeral subtractive notation and boundary validation
- LargeNumber auto-detect, explicit targets, edge cases
- Carbon/DateTime/string input acceptance tests
- Custom template and config override tests
- Backward compatibility tests for deprecated `period()` and `short()` methods

## 2.1.0 - 2026-02-21

### Changed
- **BREAKING**: Minimum PHP version is now `^8.1` (dropped PHP 7.4 and 8.0)
- **BREAKING**: Minimum Laravel version is now 10.x (dropped Laravel 8 and 9)
- Replaced `spatie/laravel-package-tools` with native `Illuminate\Support\ServiceProvider`
- Updated `phpunit.xml.dist` to PHPUnit 10+ schema

### Fixed
- Fixed number overflow check for PHP 8.5 compatibility (float-to-int cast)

### CI
- Simplified test matrix for PHP 8.1–8.5 and Laravel 10–13
- Added PHP 8.1 CI support via Pest v1 + PHPUnit 9 downgrade
- Bumped PHPStan workflow to PHP 8.2

## 2.0.x

### Supported
- PHP ^7.4 | ^8.0
- Laravel 8.x – 9.x

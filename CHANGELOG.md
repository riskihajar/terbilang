# Changelog

All notable changes to `terbilang` will be documented in this file.

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

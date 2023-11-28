# Number To Words Conversion For Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/riskihajar/terbilang.svg?style=flat-square)](https://packagist.org/packages/riskihajar/terbilang)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/riskihajar/terbilang/run-tests.yml?branch=2.x&label=tests&style=flat-square)](https://github.com/riskihajar/terbilang/actions?query=workflow%3Arun-tests+branch%3A2.x)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/riskihajar/terbilang/fix-php-code-style-issues.yml?branch=2.x&label=code%20style&style=flat-square)](https://github.com/riskihajar/terbilang/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3A2.x)
[![Total Downloads](https://img.shields.io/packagist/dt/riskihajar/terbilang.svg?style=flat-square)](https://packagist.org/packages/riskihajar/terbilang)

Number to words conversion support multi language.

### Supported Language
* `id` | Bahasa Indonesia
* `en` | English
* `pt` | Portuguese
* soon

### Feature
* [Number to Words](https://github.com/riskihajar/terbilang#number-to-words)
* [Number to Roman](https://github.com/riskihajar/terbilang#number-to-roman)
* [Number Large Conversion](https://github.com/riskihajar/terbilang#number-large-conversion) (Number Short Hand in past version)
* [Datetime to Words](https://github.com/riskihajar/terbilang#datetime)
* [Distance Date](https://github.com/riskihajar/terbilang#distance-date) (Period in past version)

## Version Compatibility

 Laravel  | Terbilang
:---------|:----------
 4.x      | 1.0.4       
 5.x      | 1.2.x       
 6.x      | 1.2.x       
 7.x      | 1.2.x       
 8.x      | 2.x        
 9.x      | 2.x       
 10.x     | 2.x       

## Installation

You can install the package via composer:

```bash
composer require riskihajar/terbilang:^2.0
```

## Usage

#### Add Providers & Aliases
In the `$providers` array add the service providers for this package.
```php
Riskihajar\Terbilang\TerbilangServiceProvider::class,
```
Add the facade of this package to the `$aliases` array.
```php
'Terbilang' => Riskihajar\Terbilang\Facades\Terbilang::class,
```

#### Publish Configuration (Optional)
If you want customize configuration, you can run following command to publish config file
```
php artisan vendor:publish --provider="Riskihajar\Terbilang\TerbilangServiceProvider"
```
This is the contents of the published config file:

```php
return [
    'output' => [
        'date' => '{DAY} {MONTH} {YEAR}',
        'time' => '{HOUR} {SEPARATOR} {MINUTE} {MINUTE_LABEL} {SECOND} {SECOND_LABEL}',
    ],

    'locale' => 'en',

    'distance' => [
        'type' => \Riskihajar\Terbilang\Enums\DistanceDate::Day,
        'template' => '{YEAR} {MONTH} {DAY} {HOUR} {MINUTE} {SECOND}',
        'hide_zero_value' => true,
        'separator' => ' ',
        'terbilang' => false,
        'show' => [
            'year' => true,
            'month' => true,
            'day' => true,
            'hour' => true,
            'minute' => true,
            'second' => true,
        ],
    ],
];
```

### Examples
#### Number To Words
`Terbilang::make($number, $suffix, $prefix)`

if you set locale to en
```php
Config::set('terbilang.locale', 'en');

Terbilang::make(1000000); // one million
```
if you set locale to id
```php
Config::set('terbilang.locale', 'id');

Terbilang::make(1000000); // satu juta
```

##### Prefix & Suffix
if you set locale to id
```php
Terbilang::make(123456, ' rupiah', 'senilai ');
// senilai seratus dua puluh tiga ribu, empat ratus lima puluh enam rupiah
```
if you set locale to en
```php
Terbilang::make(654321, ' dollars');
// six hundred and fifty-four thousand, three hundred and twenty-one dollars
```

#### Number to Roman
`Terbilang::roman($number, $lowercase=false)`
```php
Terbilang::roman(1234); // MCCXXXIV
```

#### Number Large Conversion
`Terbilang::short($number, $format)`

Available short hand : `kilo, million, billion, trillion`

Default value : `million`

if you set locale to en
```php
Terbilang::short(1000000); // 1M
```
if you set locale to id
```php
Terbilang::short(1000000); // 1jt
```

#### Datetime
##### Date `Terbilang::date($date, $format='Y-m-d');`
```php
$date = date('Y-m-d'); // 2015-03-31
Terbilang::date($date);
// Result : tiga puluh satu maret dua ribu lima belas
```
##### Time `Terbilang::time($date, $format='h:i:s');`
```php
$date = date('h:i:s'); //10:56:30
Terbilang::time($date);
// Result : sepuluh lewat lima puluh enam menit tiga puluh tiga detik
```
##### Date Time `Terbilang::datetime($date, $format='Y-m-d h:i:s');`
```php
$date = date('Y-m-d h:i:s'); // 2015-03-31 10:58:27
Terbilang::datetime($date);
// Result : tiga puluh satu maret dua ribu lima belas pukul sepuluh lewat lima puluh delapan menit dua puluh tujuh detik
```
##### Using Carbon
if using carbon, you can ignore `$format`
```php
$dt = Carbon\Carbon::now('Asia/Makassar');

$date = Terbilang::date($dt);
$time = Terbilang::time($dt);
$datetime = Terbilang::datetime($dt);
```

#### Distance Date
You can diff two dates or just one date and automaticly with current date use method `Terbilang::distance($start, $end=null, $format=null)`

##### Config for distance format
```php
'distance' => [
     'type' => 'FULL',
     'format' => '{YEAR} {MONTH} {DAY} {HOUR} {MINUTE} {SECOND}',
     'hide_zero_value' => true,
     'separator' => ' ',
     'terbilang' => false,
     'show' => [
         'year' => true,
         'month' => true,
         'day' => true,
         'hour' => true,
         'minute' => true,
         'second' => true,
     ]
 ],
```

##### Example Distance
```php
$date1 = date('Y-m-d', strtotime('2017-05-01')); // dateformat must Y-m-d H:i:s
$date2 = date('Y-m-d', strtotime('2017-06-15 09:30:15'));

// this method will diff $date1 with current datetime value for example current datetime : 2017-09-08 15:17:54
Terbilang::period($date1); // Result : 4 months 8 days 15 hours 17 minutes 54 seconds

Terbilang::period($date1, $date2); // Result : 1 months 15 days 9 hours 30 minutes 15 seconds

// if you set locale to id
Terbilang::period($date1, $date2); // Result : 1 bulan 15 hari 9 jam 30 menit 15 detik

// if you set config period.terbilang to true
Terbilang::period($date1, $date2); // Result : satu bulan lima belas hari sembilan jam tiga puluh menit lima belas detik

// if you set config period.type to DAY
Terbilang::period($date1, $date2); // Result : 45 hari

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rizky Hajar](https://github.com/riskihajar)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

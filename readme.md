## Number To Words Conversion For Laravel
[![Build Status](https://travis-ci.org/riskihajar/terbilang.svg?branch=master)](https://travis-ci.org/riskihajar/terbilang)
[![Latest Stable Version](https://poser.pugx.org/riskihajar/terbilang/v/stable.svg)](https://packagist.org/packages/riskihajar/terbilang)
[![Total Downloads](https://poser.pugx.org/riskihajar/terbilang/downloads.svg)](https://packagist.org/packages/riskihajar/terbilang)
[![Latest Unstable Version](https://poser.pugx.org/riskihajar/terbilang/v/unstable.svg)](https://packagist.org/packages/riskihajar/terbilang)
[![License](https://poser.pugx.org/riskihajar/terbilang/license.svg)](https://github.com/riskihajar/terbilang/blob/master/LICENSE)

Number to words conversion support multi language.

### Supported Language
* `id` | Bahasa Indonesia
* `en` | English
* `pt` | Portuguese
* soon

### Feature
* [Number to Word](https://github.com/riskihajar/terbilang#number-to-words)
* [Number to Roman](https://github.com/riskihajar/terbilang#number-to-roman)
* [Datetime to Word](https://github.com/riskihajar/terbilang#datetime)

### Usage

#### Step 1: Install Through Composer
```
composer require riskihajar/terbilang
```
or add this to `composer.json`
```
    "riskihajar/terbilang": "1.0.5"
```
then run `composer update`

For Laravel 4 Please use `1.0.4` version


#### Step 2: Add Providers & Aliases
In the `$providers` array add the service providers for this package.
```
Riskihajar\Terbilang\TerbilangServiceProvider::class,
```
Add the facade of this package to the `$aliases` array.
```
'Terbilang' => Riskihajar\Terbilang\Facades\Terbilang::class,
```

### Examples
#### Number To Words
`Terbilang::make($number, $suffix, $prefix)`
if you set locale to en
```
Terbilang::make(1000000); // one million
```
if you set locale to id
```
Terbilang::make(1000000); // satu juta
```

##### Prefix & Suffix
if you set locale to id
```
Terbilang::make(123456, ' rupiah', 'senilai ');
// senilai seratus dua puluh tiga ribu, empat ratus lima puluh enam rupiah
```
if you set locale to en
```
Terbilang::make(654321, ' dollars');
// six hundred and fifty-four thousand, three hundred and twenty-one dollars
```

#### Number to Roman
`Terbilang::roman($number, $lowercase=false)`
```
Terbilang::roman(1234); //MCCXXXIV
```

#### Datetime
##### Date `Terbilang::date($date, $format='Y-m-d');`
```
$date = date('Y-m-d'); // 2015-03-31
Terbilang::date($date);
// Result : tiga puluh satu maret dua ribu lima belas
```
##### Time `Terbilang::time($date, $format='h:i:s');`
```
$date = date('h:i:s'); //10:56:30
Terbilang::time($date);
// Result : sepuluh lewat lima puluh enam menit tiga puluh tiga detik
```
##### Date Time `Terbilang::datetime($date, $format='Y-m-d h:i:s');`
```
$date = date('Y-m-d h:i:s'); // 2015-03-31 10:58:27
Terbilang::datetime($date);
// Result : tiga puluh satu maret dua ribu lima belas pukul sepuluh lewat lima puluh delapan menit dua puluh tujuh detik
```
##### Using Carbon
if using carbon, you can ignore `$format`
```
$dt = Carbon\Carbon::now('Asia/Makassar');

$date = Terbilang::date($dt);
$time = Terbilang::time($dt);
$datetime = Terbilang::datetime($dt);
```

## Number To Word Conversion For Laravel 4
Number to word conversion support multi language.

### Supported Language
* `id` | *Indonesian*
* `en` | *English*
* soon

### Feature
* [Number to Word](https://github.com/riskihajar/terbilang#examples)
* [Datetime to Word](https://github.com/riskihajar/terbilang#datetime)

### Usage

#### Step 1: Install Through Composer
```
composer require riskihajar/terbilang --dev
````

#### Step 2: Add Providers & Aliases
In the `$providers` array add the service providers for this package.
```
'Riskihajar\Terbilang\TerbilangServiceProvider',
```
Add the facade of this package to the `$aliases` array.
```
'Terbilang' => 'Riskihajar\Terbilang\Facades\Terbilang',
```

### Examples
Basic :
```
Terbilang::make(1000000);
```
Result : 
```
one million
```
for *en* `locale`
```
satu juta
```
for *id* `locale`

#### Prefix & Suffix
Syntax :
```
Terbilang::make(123456, ' rupiah', 'senilai ');
```
Result `id` :
```
senilai seratus dua puluh tiga ribu, empat ratus lima puluh enam rupiah
```
Syntax : 
```
Terbilang::make(654321, ' dollars');
```
Result `en` :
```
six hundred and fifty-four thousand, three hundred and twenty-one dollars
```

#### Datetime
##### Date `Terbilang::date($date, $format='Y-m-d');`
```
<?php

$date = date('Y-m-d'); // 2015-03-31
Terbilang::date($date);
// Result : tiga puluh satu maret dua ribu lima belas
```
##### Time `Terbilang::time($date, $format='h:i:s');`
```
<?php
$date = date('h:i:s'); //10:56:30
Terbilang::time($date);
// Result : sepuluh lewat lima puluh enam menit tiga puluh tiga detik
```
##### Date Time `Terbilang::datetime($date, $format='Y-m-d h:i:s');`
```
<?php
$date = date('Y-m-d h:i:s'); // 2015-03-31 10:58:27:
Terbilang::datetime($date);
// Result : tiga puluh satu maret dua ribu lima belas pukul sepuluh lewat lima puluh delapan menit dua puluh tujuh detik
```
##### Using Carbon
if using carbon, you can ignore `$format`
```
<?php

$dt = Carbon\Carbon::now('Asia/Makassar');

$date = Terbilang::date($dt);
$time = Terbilang::time($dt);
$datetime = Terbilang::datetime($dt);
```

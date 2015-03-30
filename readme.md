# Number To Word Conversion For Laravel 4
Number to word conversion support multi language.

## Supported Langugage
* `id` | *Indonesian*
* `en` | *English*
* soon

## Usage

### Step 1: Install Through Composer
```
composer require riskihajar/terbilang --dev
````

### Step 2: Add Providers & Aliases
In the `$providers` array add the service providers for this package.
```
'Riskihajar\Terbilang\TerbilangServiceProvider',
```
Add the facade of this package to the `$aliases` array.
```
'Terbilang' => 'Riskihajar\Terbilang\Facades\Terbilang',
```

## Examples
Basic :
```
Terbilang::make(1000000);
```
Result : `one million` in *en* | `satu juta` in *id* `locale`

### Prefix & Suffix
Syntax :
```
Terbilang::make(123456, ' rupiah', 'senilai ');
```
Result : `senilai satu ratus dua puluh tiga ribu, empat ratus lima puluh enam rupiah`


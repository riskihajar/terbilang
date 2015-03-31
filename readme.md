## Number To Word Conversion For Laravel 4
Number to word conversion support multi language.

### Supported Langugage
* `id` | *Indonesian*
* `en` | *English*
* soon

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
Terbilang::make(654321, ' dolars');
```
Result `en` :
```
six hundred and fifty-four thousand, three hundred and twenty-one dolars
```

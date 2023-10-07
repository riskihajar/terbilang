<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class NumberToWords
{
    private $hyphen;

    private $conjunction;

    private $separator;

    private $negative;

    private $decimal;

    private $dictionary;

    private $prenum;

    private $locale;

    /** @return void  */
    public function __construct()
    {
        $this->locale = config('terbilang.locale') ?: config('app.locale');
        $this->hyphen = Lang::get('terbilang::terbilang.hyphen', [], $this->locale);
        $this->conjunction = Lang::get('terbilang::terbilang.conjunction', [], $this->locale);
        $this->separator = Lang::get('terbilang::terbilang.separator', [], $this->locale);
        $this->negative = Lang::get('terbilang::terbilang.negative', [], $this->locale);
        $this->decimal = Lang::get('terbilang::terbilang.decimal', [], $this->locale);
        $this->dictionary = Lang::get('terbilang::terbilang.dictionary', [], $this->locale);
        $this->prenum = Lang::get('terbilang::terbilang.prenum', [], $this->locale);
    }

    /**
     * @throws Exceptions\InvalidNumber
     */
    private function parseNumber(mixed $number): mixed
    {
        // parse quoted value and make sure its number
        $number = floatval($number);

        $isScientific = preg_match('/^[+-]?[0-9]+(\.[0-9]+)?[eE][+-]?[0-9]+$/', $number);

        if ($isScientific) { // handle scientific value like 1.0E+15 after parse quoted
            $number = sprintf('%0d', $number);
        }

        if (
            ($number >= 0 && intval($number) < 0)
            || (intval($number) < 0 - PHP_INT_MAX)
            || $number >= 10_000_000_000_000_000
        ) {
            throw Exceptions\InvalidNumber::isExceed();
        }

        return $number;
    }

    private function spellout($number): Stringable
    {
        $formatter = new \NumberFormatter($this->locale, \NumberFormatter::SPELLOUT);

        return Str::of($formatter->format($number));
    }

    /**
     * @throws Exceptions\InvalidNumber
     */
    public function make(mixed $number): Stringable
    {
        if (! is_numeric($number)) {
            throw Exceptions\InvalidNumber::isNotNumeric();
        }

        $number = $this->parseNumber(number: $number);

        if (extension_loaded('intl') && config('terbilang.use_intl', true)) {
            return $this->spellout($number);
        }

        if ($number < 0) {
            return $this->make(number: abs($number))->prepend($this->negative, ' ');
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            [$number, $fraction] = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $this->dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $this->dictionary[$tens];
                if ($units) {
                    $string .= $this->hyphen.$this->dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remains = $number % 100;
                if ($this->prenum) {
                    $lead = (int) substr($number, 0, 1);
                    $string = ($lead === 1 ? $this->prenum : $this->dictionary[$hundreds].' ').$this->dictionary[100];
                } else {
                    $string = $this->dictionary[$hundreds].' '.$this->dictionary[100];
                }
                if ($remains) {
                    $string .= $this->conjunction.$this->make($remains);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remains = $number % $baseUnit;

                if ($this->prenum) {
                    $string = ($numBaseUnits === 1 && $baseUnit < 1000000 ? $this->prenum : $this->make($numBaseUnits).' ').$this->dictionary[$baseUnit];
                } else {
                    $string = $this->make($numBaseUnits).' '.$this->dictionary[$baseUnit];
                }

                if ($remains) {
                    $string .= $remains < 100 ? $this->conjunction : $this->separator;
                    $string .= $this->make($remains);
                }
                break;
        }

        if ($fraction !== null && is_numeric($fraction)) {
            $string .= $this->decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $this->dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return Str::of($string);
    }
}

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

    private $prefix;

    private $suffix;

    private $prenum;

    /** @return void  */
    public function __construct()
    {
        $this->hyphen = Lang::get('terbilang::terbilang.hyphen');
        $this->conjunction = Lang::get('terbilang::terbilang.conjunction');
        $this->separator = Lang::get('terbilang::terbilang.separator');
        $this->negative = Lang::get('terbilang::terbilang.negative');
        $this->decimal = Lang::get('terbilang::terbilang.decimal');
        $this->dictionary = Lang::get('terbilang::terbilang.dictionary');
        $this->prefix = Lang::get('terbilang::terbilang.prefix');
        $this->suffix = Lang::get('terbilang::terbilang.suffix');
        $this->prenum = Lang::get('terbilang::terbilang.prenum');
    }

    public function suffix(string|null $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function prefix(string|null $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @throws Exceptions\InvalidNumber
     */
    private function parseNumber(mixed $number): mixed
    {
        // parse quoted value and make sure its number
        $number = floatval($number);

        // handle scientific value like 1.0E+15 after parse quoted
        $number = sprintf('%0d', $number);

        if (($number >= 0 && intval($number) < 0) || (intval($number) < 0 - PHP_INT_MAX)) {
            throw Exceptions\InvalidNumber::isExceed();
        }

        return $number;
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

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $this->decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $this->dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return Str::of($string)
            ->prepend($this->prefix, $this->prefix ? ' ' : '')
            ->append($this->suffix, $this->suffix ? ' ' : '');
    }
}

<?php namespace Riskihajar\Terbilang;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

class Terbilang{

    protected $hyphen;
    protected $conjunction;
    protected $separator;
    protected $negative;
    protected $decimal;
    protected $dictionary;
    protected $prefix;
    protected $suffix;
    protected $prenum;

    protected $lang;

    public function __construct()
    {
        $this->hyphen      = Lang::get('terbilang::terbilang.hyphen');
        $this->conjunction = Lang::get('terbilang::terbilang.conjunction');
        $this->separator   = Lang::get('terbilang::terbilang.separator');
        $this->negative    = Lang::get('terbilang::terbilang.negative');
        $this->decimal     = Lang::get('terbilang::terbilang.decimal');
        $this->dictionary  = Lang::get('terbilang::terbilang.dictionary');
        $this->prefix      = Lang::get('terbilang::terbilang.prefix');
        $this->suffix      = Lang::get('terbilang::terbilang.suffix');
        $this->prenum      = Lang::get('terbilang::terbilang.prenum');

        $this->lang = Config::get('app.locale');
    }

    public function make($number, $suffix=false, $prefix=false)
    {
        $prefix = $prefix ? $prefix : $this->prefix;
        $suffix = $suffix ? $suffix : $this->suffix;

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'NumToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $this->negative . Helper::NumToWords(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $this->dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $this->dictionary[$tens];
                if ($units) {
                    $string .= $this->hyphen . $this->dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                // $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                $string = ($hundreds === 1 ? $this->prenum : $this->dictionary[$hundreds] . ' ') . $this->dictionary[100];
                if ($remainder) {
                    $string .= $this->conjunction . $this->make($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $numBaseUnits;
                if($this->prenum) {
                    $string = (($numBaseUnits === 1 && $number < 1000000) ? $this->prenum : $this->make(
                                $numBaseUnits
                            ) . ' ') . $this->dictionary[$baseUnit];
                }else{
                    $string = $this->make($numBaseUnits) . ' ' . $this->dictionary[$baseUnit];
                }

                if ($remainder) {
                    $string .= $remainder < 100 ? $this->conjunction : $this->separator;
                    $string .= $this->make($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $this->decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $this->dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $prefix . $string . $suffix;
    }

}
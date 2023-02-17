<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use Riskihajar\Terbilang\Enums\Roman;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Terbilang
{
    public function date()
    {

    }

    public function time()
    {
        
    }

    public function datetime($datetime, $format='Y-m-d h:i:s'): Stringable
    {
        if(!$datetime instanceof Carbon){
            $datetime = Carbon::createFromFormat($format, $datetime);
        }

        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('h:i:s');
        $separator = Lang::get('terbilang::date.time.dt-separator');

        $string = implode(" ", array_filter([
            $this->date($date),
            $separator,
            $this->time($time),
        ]));

        return Str::of($string);
    }

    public function roman($number): Stringable
    {
        $number = intval($number);

        $results = [];

        
        foreach(Roman::cases() as $roman){

            $matches = intval($number / $roman->value);

            $results[] = str_repeat($roman->label(), $matches);

            $number = $number % $roman->value;
        }


        $results = array_filter($results);

        $string = implode('', $results);

        return Str::of($string);
    }
}

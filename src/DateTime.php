<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use Illuminate\Support\Str;

class DateTime
{
    public function date()
    {
    }

    public function time()
    {
    }

    public function datetime($datetime, $format = 'Y-m-d h:i:s'): Stringable
    {
        if (! $datetime instanceof Carbon) {
            $datetime = Carbon::createFromFormat($format, $datetime);
        }

        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('h:i:s');
        $separator = Lang::get('terbilang::date.time.dt-separator');

        $string = implode(' ', array_filter([
            $this->date($date),
            $separator,
            $this->time($time),
        ]));

        return Str::of($string);
    }
}

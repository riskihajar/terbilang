<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class DateTime
{
    public function date(Carbon|string $date, string $format = 'Y-m-d')
    {
        if (! $date instanceof Carbon) {
            $date = Carbon::createFromFormat($date, $format);
        }

        $j = $date->format('j');
        $n = $date->format('n');
        $Y = $date->format('Y');

        $day = $this->make($j);
        $month = strtolower(Lang::get('terbilang::date.month.'.$n));
        $year = $this->make($Y);

        $template = config('terbilang.output.date', '{DAY} {MONTH} {YEAR}');
        $string = str_replace([
            '{DAY}',
            '{MONTH}',
            '{YEAR}',
        ], [
            $day,
            $month,
            $year,
        ], $template);

        return Str::of($string);
    }

    public function time()
    {
    }

    public function datetime(Carbon|string $datetime, string $format = 'Y-m-d h:i:s'): Stringable
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

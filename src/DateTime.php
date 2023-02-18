<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Exceptions\InvalidNumber;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

/** @package Riskihajar\Terbilang */
class DateTime
{
    /**
     * @param Carbon|string $date
     * @param string $format
     * @return Stringable
     * @throws InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function date(Carbon|string $date, string $format = 'Y-m-d'): Stringable
    {
        if (! $date instanceof Carbon) {
            $date = Carbon::createFromFormat($format, $date);
        }

        $j = $date->format('j');
        $n = $date->format('n');
        $Y = $date->format('Y');

        $numberToWords = new NumberToWords;

        $day = $numberToWords->make($j);
        $month = strtolower(Lang::get('terbilang::date.month.'.$n));
        $year = $numberToWords->make($Y);

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

    /**
     * @param Carbon|string $time
     * @param string $format
     * @return Stringable
     * @throws InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function time(Carbon|string $time, string $format = 'H:i:s'): Stringable
    {
        if (! $time instanceof Carbon) {
            $time = Carbon::createFromFormat($format, $time);
        }

        $G = $time->format('G');
        $i = $time->format('i');
        $s = intval($time->format('s')) ?: null;

        $separator = Lang::get('terbilang::date.time.minute-separator');
        $strMinute = Lang::get('terbilang::date.time.minute');
        $strSecond = $s ? Lang::get('terbilang::date.time.second') : null;

        $numberToWords = new NumberToWords;

        $hour = $numberToWords->make($G);
        $minute = $numberToWords->make($i);
        $second = $s ? $numberToWords->make($s) : null;

        $template = config('terbilang.output.time', '{HOUR} {SEPARATOR} {MINUTE} {MINUTE_LABEL} {SECOND} {SECOND_LABEL}');

        $string = str_replace(
            [
                '{HOUR}', '{SEPARATOR}', '{MINUTE}', '{MINUTE_LABEL}', '{SECOND}', '{SECOND_LABEL}',
            ],
            [
                $hour->toString(), $separator, $minute->toString(), $strMinute, $second?->toString(), $strSecond,
            ],
            $template
        );

        return Str::of($string)->trim();
    }

    /**
     * @param Carbon|string $datetime
     * @param string $format
     * @return Stringable
     * @throws InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function datetime(Carbon|string $datetime, string $format = 'Y-m-d H:i:s'): Stringable
    {
        if (! $datetime instanceof Carbon) {
            $datetime = Carbon::createFromFormat($format, $datetime);
        }

        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('h:i:s');

        $meridiem = value(function () use ($datetime) {
            $result = Lang::get('terbilang::date.time.'.$datetime->format('a'));

            if (is_array($result)) {
                $hour = $datetime->format('H');

                foreach ($result as $h => $result) {
                    if ($h <= $hour) {
                        break;
                    }
                }
            }

            return $result;
        });

        $separator = Lang::get('terbilang::date.time.dt-separator');

        $string = implode(' ', array_filter([
            $this->date($date)->toString(),
            $separator,
            $this->time($time)->toString(),
            $meridiem,
        ]));

        return Str::of($string)->trim();
    }
}

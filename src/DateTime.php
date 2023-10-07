<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Riskihajar\Terbilang\Exceptions\InvalidNumber;

class DateTime
{
    /**
     * Parses a given date into a Carbon object, using the given format.
     *
     * @param  Carbon|string|\DateTime  $date The date to parse.
     * @param  string  $format The format to use when parsing the date.
     * @return Carbon The parsed date as a Carbon object.
     */
    protected function parseDate(Carbon|string|\DateTime $date, string $format = 'Y-m-d'): Carbon
    {
        if (! $date instanceof Carbon) {
            if ($date instanceof \DateTime) {
                $date = Carbon::parse($date);
            } else {
                $date = Carbon::createFromFormat($format, $date);
            }
        }

        return $date;
    }

    /**
     * @throws InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function date(Carbon|string|\DateTime $date, string $format = 'Y-m-d'): Stringable
    {
        $date = $this->parseDate($date, $format);

        $j = $date->format('j');
        $n = $date->format('n');
        $Y = $date->format('Y');

        $numberToWords = new NumberToWords;

        $day = $numberToWords->make($j);
        $month = strtolower(Lang::get('terbilang::date.month.'.$n, [], config('terbilang.locale') ?: config('app.locale')));
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
     * @throws InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function time(Carbon|string|\DateTime $time, string $format = 'H:i:s'): Stringable
    {
        $time = $this->parseDate($time, $format);

        $G = $time->format('G');
        $i = $time->format('i');
        $s = intval($time->format('s')) ?: null;

        $separator = Lang::get('terbilang::date.time.minute-separator', [], config('terbilang.locale') ?: config('app.locale'));
        $strMinute = Lang::get('terbilang::date.time.minute', [], config('terbilang.locale') ?: config('app.locale'));
        $strSecond = $s ? Lang::get('terbilang::date.time.second', [], config('terbilang.locale') ?: config('app.locale')) : null;

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
                $hour, $separator, $minute, $strMinute, $second, $strSecond,
            ],
            $template
        );

        return Str::of($string)->trim();
    }

    /**
     * @throws InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function datetime(Carbon|string|\DateTime $datetime, string $format = 'Y-m-d H:i:s'): Stringable
    {
        $datetime = $this->parseDate($datetime, $format);

        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('h:i:s');

        $locale = config('terbilang.locale') ?: config('app.locale');

        $meridiem = value(function () use ($datetime, $locale) {
            $result = Lang::get('terbilang::date.time.'.$datetime->format('a'), [], $locale);

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

        $separator = Lang::get('terbilang::date.time.dt-separator', [], $locale);

        $string = implode(' ', array_filter([
            $this->date($date)->toString(),
            $separator,
            $this->time($time)->toString(),
            $meridiem,
        ]));

        return Str::of($string)->trim();
    }
}

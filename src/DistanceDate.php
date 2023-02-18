<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\DistanceDate as Enum;

class DistanceDate
{
    private array $config = [];

    public function __construct()
    {
        $this->config = Config::get('terbilang.distance', []);
    }

    public function config(array $config): self
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }

    public function make(
        Carbon $start,
        Carbon|null $end = null): Stringable
    {
        if (is_null($end)) {
            $end = Carbon::now();
        }

        $type = $this->config['type'];

        $interval = $start->diff($end);

        if ($type === Enum::Full) {
            return $this->full($interval);
        } else {
            return $this->type($interval, $type);
        }
    }

    private function full(DateInterval $interval): Stringable
    {
        $result = $interval->format('%y %m %d %h %i %s');
        [$year, $month, $day, $hour, $minute, $second] = explode(' ', $result);

        $listFormat = [
            '{YEAR}' => [
                'value' => $year,
                'label' => Lang::get('terbilang::date.dictionary.year'),
                'show' => config('terbilang.period.show.year'),
            ],
            '{MONTH}' => [
                'value' => $month,
                'label' => Lang::get('terbilang::date.dictionary.month'),
                'show' => config('terbilang.period.show.month'),
            ],
            '{DAY}' => [
                'value' => $day,
                'label' => Lang::get('terbilang::date.dictionary.day'),
                'show' => config('terbilang.period.show.day'),
            ],
            '{HOUR}' => [
                'value' => $hour,
                'label' => Lang::get('terbilang::date.dictionary.hour'),
                'show' => config('terbilang.period.show.hour'),
            ],
            '{MINUTE}' => [
                'value' => $minute,
                'label' => Lang::get('terbilang::date.dictionary.minute'),
                'show' => config('terbilang.period.show.minute'),
            ],
            '{SECOND}' => [
                'value' => $second,
                'label' => Lang::get('terbilang::date.dictionary.second'),
                'show' => config('terbilang.period.show.second'),
            ],
        ];

        $template = $this->config['template'];
        $results = [];
        $hideZeroValue = $this->config['hide_zero_value'];
        $terbilang = $this->config['terbilang'];
        $separator = $this->config['separator'];
        $numberToWords = new NumberToWords;

        foreach (explode(' ', $template) as $key) {
            $value = $listFormat[$key]['value'];
            $label = $listFormat[$key]['label'];
            $show = $listFormat[$key]['show'];

            if (($value <= 0 && $hideZeroValue) || ! $show) {
                continue;
            }

            if ($terbilang) {
                $value = $numberToWords->make($value);
            }

            $results[] = $value.$separator.$label;
        }

        return Str::of(implode(' ', $results))->trim();
    }

    private function type(DateInterval $interval, Enum $type): Stringable
    {
        $terbilang = $this->config['terbilang'];
        $separator = $this->config['separator'];
        $numberToWords = new NumberToWords;

        if ($type === Enum::Year) {
            $value = $interval->format('%y');
        }

        $value = match ($type) {
            Enum::Year => $interval->format('%y'),
            Enum::Month => $interval->format('%m'),
            Enum::Day => $interval->format('%a'),
            Enum::Hour => intval($interval->format('%h')) + (intval($interval->format('%a')) * 24),
            Enum::Minute => intval($interval->format('%i')) + (intval($interval->format('%a')) * 24 * 60),
            Enum::Second => intval($interval->format('%s')) + (intval($interval->format('%a')) * 24 * 60 * 60),
            default => null,
        };

        $label = $type->label();

        if ($terbilang) {
            $value = $numberToWords->make($value);
        }

        $result = $separator.$value.$separator.$label;

        return Str::of($result)->trim();
    }
}

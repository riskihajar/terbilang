<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use DateInterval;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Riskihajar\Terbilang\Enums\DistanceDate as Enum;
use Riskihajar\Terbilang\Exceptions\InvalidNumber;

class DistanceDate
{
    private array $config = [];

    /** @return void  */
    public function __construct()
    {
        $this->config = Config::get('terbilang.distance', []);
    }

    public function config(array $config): self
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }

    /**
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws InvalidNumber
     */
    public function make(
        Carbon $start,
        Carbon $end = null): Stringable
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

    /**
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws InvalidNumber
     */
    private function full(DateInterval $interval): Stringable
    {
        $result = $interval->format('%y %m %d %h %i %s');
        [$year, $month, $day, $hour, $minute, $second] = explode(' ', $result);

        $locale = config('terbilang.locale') ?: config('app.locale');

        $listFormat = [
            '{YEAR}' => [
                'value' => $year,
                'label' => Lang::get('terbilang::date.dictionary.year', [], $locale),
                'show' => config('terbilang.period.show.year'),
            ],
            '{MONTH}' => [
                'value' => $month,
                'label' => Lang::get('terbilang::date.dictionary.month', [], $locale),
                'show' => config('terbilang.period.show.month'),
            ],
            '{DAY}' => [
                'value' => $day,
                'label' => Lang::get('terbilang::date.dictionary.day', [], $locale),
                'show' => config('terbilang.period.show.day'),
            ],
            '{HOUR}' => [
                'value' => $hour,
                'label' => Lang::get('terbilang::date.dictionary.hour', [], $locale),
                'show' => config('terbilang.period.show.hour'),
            ],
            '{MINUTE}' => [
                'value' => $minute,
                'label' => Lang::get('terbilang::date.dictionary.minute', [], $locale),
                'show' => config('terbilang.period.show.minute'),
            ],
            '{SECOND}' => [
                'value' => $second,
                'label' => Lang::get('terbilang::date.dictionary.second', [], $locale),
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

    /**
     * @throws InvalidNumber
     */
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

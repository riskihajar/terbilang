<?php

namespace Riskihajar\Terbilang;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Stringable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Terbilang
{
    /**
     * @throws Exceptions\InvalidNumber
     */
    public function make(mixed $number, string|null $suffix = null, string|null $prefix = null): Stringable
    {
        $prefix = $prefix ?: Lang::get('terbilang::terbilang.prefix');
        $suffix = $suffix ?: Lang::get('terbilang::terbilang.suffix');

        return (new NumberToWords)
            ->make(number: $number)
            ->prepend($prefix, $prefix ? ' ' : '')
            ->append($suffix, $suffix ? ' ' : '')
            ->trim();
    }

    /**
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws Exceptions\InvalidNumber
     */
    public function distance(Carbon $start, Carbon $end): Stringable
    {
        return (new DistanceDate)->make(start: $start, end: $end);
    }

    /**
     * @param  null|Carbon|string  $end
     * @param  mixed  $template
     *
     * @deprecated
     */
    public function period(
        Carbon|string $start,
        Carbon|string|null $end = null,
        $template = null
    ): Stringable {
        if (! $start instanceof Carbon) {
            $start = Carbon::parse($start);
        }

        if (gettype($end) === 'string') {
            $end = Carbon::parse($end);
        }

        if (is_null($template)) {
            $template = config('terbilang.distance.template');
        }

        return (new DistanceDate)->config([
            'template' => $template,
        ])->make(start: $start, end: $end);
    }

    /**
     * @throws Exceptions\InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function date(Carbon|string $date, string $format = 'Y-m-d'): Stringable
    {
        return (new DateTime)->date(date: $date, format: $format);
    }

    /**
     * @throws Exceptions\InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function time(Carbon|string $time, string $format = 'H:i:s'): Stringable
    {
        return (new DateTime)->time(time: $time, format: $format);
    }

    /**
     * @throws Exceptions\InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function datetime(Carbon|string $datetime, string $format = 'Y-m-d H:i:s'): Stringable
    {
        return (new DateTime)->datetime(datetime: $datetime, format: $format);
    }

    public function largeNumber(mixed $number, Enums\LargeNumber $target = Enums\LargeNumber::Million): Stringable
    {
        return (new LargeNumber)(number: $number, target: $target);
    }

    /**
     * @deprecated
     */
    public function short(mixed $number, Enums\LargeNumber|string $target = Enums\LargeNumber::Million): Stringable
    {
        if (gettype($target) === 'string') {
            $target = Enums\LargeNumber::from($target);
        }

        return $this->largeNumber(number: $number, target: $target);
    }

    public function roman(mixed $number): Stringable
    {
        return (new Roman)(number: $number);
    }
}

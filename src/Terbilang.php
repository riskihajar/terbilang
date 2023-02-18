<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Stringable;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

/** @package Riskihajar\Terbilang */
class Terbilang
{
    /**
     * @param mixed $number
     * @return Stringable
     * @throws Exceptions\InvalidNumber
     */
    public function make(mixed $number): Stringable
    {
        return (new NumberToWords)->make(number: $number);
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return Stringable
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
     * @param Carbon|string $date
     * @param string $format
     * @return Stringable
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
     * @param Carbon|string $time
     * @param string $format
     * @return Stringable
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
     * @param Carbon|string $datetime
     * @param string $format
     * @return Stringable
     * @throws Exceptions\InvalidNumber
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function datetime(Carbon|string $datetime, string $format = 'Y-m-d H:i:s'): Stringable
    {
        return (new DateTime)->datetime(datetime: $datetime, format: $format);
    }

    /**
     * @param mixed $number
     * @param Enums\LargeNumber $target
     * @return Stringable
     */
    public function largeNumber(mixed $number, Enums\LargeNumber $target = Enums\LargeNumber::Million): Stringable
    {
        return (new LargeNumber)(number: $number, target: $target);
    }

    /**
     * @param mixed $number
     * @return Stringable
     */
    public function roman(mixed $number): Stringable
    {
        return (new Roman)(number: $number);
    }
}

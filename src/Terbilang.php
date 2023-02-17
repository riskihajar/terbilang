<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums;

class Terbilang
{
    public function largeNumber(mixed $number, Enums\LargeNumber $target = Enums\LargeNumber::Million): Stringable
    {
        return (new LargeNumber)(number: $number, target: $target);
    }

    public function roman(mixed $number): Stringable
    {
        return (new Roman)(number: $number);
    }
}

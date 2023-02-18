<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\LargeNumber as Enum;

class LargeNumber
{
    public function __invoke(mixed $number, Enum $target = Enum::Million): Stringable
    {
        $result = round($number / $target->divider(), 2);
        $string = implode('', [
            $result,
            $target->abbreviation(),
        ]);

        return Str::of($string);
    }
}

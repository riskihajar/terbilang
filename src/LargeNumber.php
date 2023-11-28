<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\LargeNumber as Enum;

class LargeNumber
{
    public function __invoke(mixed $number, Enum $target = Enum::Auto, ?int $precision = 2): Stringable
    {
        $target = $target === Enum::Auto
            ? Enum::tryFromValue($number)
            : $target;

        $result = round($number / $target->divider(), $precision);

        $string = implode('', [
            $result,
            $target->abbreviation(),
        ]);

        return Str::of($string);
    }
}

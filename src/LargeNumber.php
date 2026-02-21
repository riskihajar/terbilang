<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\LargeNumber as Enum;

class LargeNumber
{
    public function __invoke(mixed $number, Enum $target = Enum::Auto, ?int $precision = 2): Stringable
    {
        $number = floatval($number);
        $isNegative = $number < 0;
        $absNumber = abs($number);

        // Zero or numbers too small to abbreviate when auto-detecting
        if ($absNumber == 0 || ($target === Enum::Auto && $absNumber < 1000)) {
            return Str::of((string) $number);
        }

        $target = $target === Enum::Auto
            ? Enum::tryFromValue($absNumber)
            : $target;

        $result = round($absNumber / $target->divider(), $precision);

        if ($isNegative) {
            $result = -$result;
        }

        $string = implode('', [
            $result,
            $target->abbreviation(),
        ]);

        return Str::of($string);
    }
}

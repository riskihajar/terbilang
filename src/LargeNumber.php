<?php
namespace Riskihajar\Terbilang;

use Riskihajar\Terbilang\Enums\LargeNumber as Enum;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

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

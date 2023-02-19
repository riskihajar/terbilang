<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Riskihajar\Terbilang\Enums\Roman as Enum;

class Roman
{
    public function __invoke(mixed $number): Stringable
    {
        $number = intval($number);
        $results = [];

        foreach (Enum::cases() as $roman) {
            $matches = intval($number / $roman->value);
            $results[] = str_repeat($roman->name, $matches);
            $number = $number % $roman->value;
        }

        $results = array_filter($results);
        $string = implode('', $results);

        return Str::of($string);
    }
}

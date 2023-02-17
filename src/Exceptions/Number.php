<?php

namespace Riskihajar\Terbilang\Exceptions;

use Exception;

class Number extends Exception
{
    public static function exceed(): self
    {
        return new static('NumToWords only accepts numbers between -'.PHP_INT_MIN.' and '.PHP_INT_MAX);
    }

    public static function notNumeric(): self
    {
        return new static('Number paramaters is not numeric');
    }
}

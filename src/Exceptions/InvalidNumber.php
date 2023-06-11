<?php

namespace Riskihajar\Terbilang\Exceptions;

use Exception;

final class InvalidNumber extends Exception
{
    public static function isExceed(): self
    {
        return new self('NumToWords only accepts numbers between -'.PHP_INT_MIN.' and '.PHP_INT_MAX);
    }

    public static function isNotNumeric(): self
    {
        return new self('Number paramaters is not numeric');
    }
}

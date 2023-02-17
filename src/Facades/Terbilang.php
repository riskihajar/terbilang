<?php

namespace Riskihajar\Terbilang\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Riskihajar\Terbilang\Terbilang
 */
class Terbilang extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Riskihajar\Terbilang\Terbilang::class;
    }
}

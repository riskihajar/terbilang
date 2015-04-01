<?php namespace Riskihajar\Terbilang\Facades;

use Illuminate\Support\Facades\Facade;

class Terbilang extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'terbilang';
    }
}
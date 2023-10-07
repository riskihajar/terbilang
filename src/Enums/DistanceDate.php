<?php

namespace Riskihajar\Terbilang\Enums;

use Illuminate\Support\Facades\Lang;

enum DistanceDate: string
{
    case Day = 'Day';
    case Month = 'Month';
    case Hour = 'Hour';
    case Minute = 'Minute';
    case Second = 'Second';
    case Year = 'Year';
    case Full = 'Full';

    public function label(): string
    {
        return Lang::get('terbilang::date.dictionary.'.strtolower($this->value), [], config('terbilang.locale') ?: config('app.locale'));
    }
}

<?php

namespace Riskihajar\Terbilang\Enums;

use Illuminate\Support\Facades\Lang;

enum LargeNumber: string
{
    case Auto = 'auto';
    case Kilo = 'kilo';
    case Million = 'million';
    case Billion = 'billion';
    case Trillion = 'trillion';

    public function divider(): int
    {
        return match ($this) {
            default => 1,
            self::Kilo => 10 ** 3,
            self::Million => 10 ** 6,
            self::Billion => 10 ** 9,
            self::Trillion => 10 ** 12,
        };
    }

    public static function tryFromZeroLength(?int $length): self
    {
        return match (true) {
            default => self::Kilo,
            $length >= 12 => self::Trillion,
            $length >= 9 => self::Billion,
            $length >= 6 => self::Million,
        };
    }

    public static function tryFromBaseUnit(?int $baseUnit): self
    {
        $zeros = floor(log10($baseUnit));

        return self::tryFromZeroLength($zeros);
    }

    public static function tryFromValue(?float $value): self
    {
        $baseUnit = pow(1000, floor(log($value, 1000)));

        return self::tryFromBaseUnit($baseUnit);
    }

    public function abbreviation(): ?string
    {
        $dictionary = Lang::get('terbilang::terbilang.large-number', [], config('terbilang.locale') ?: config('app.locale'));

        return $dictionary[$this->value] ?? null;
    }
}

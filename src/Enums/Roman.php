<?php

namespace Riskihajar\Terbilang\Enums;

enum Roman: int
{
    case M = 1000;
    case CM = 900;
    case D = 500;
    case CD = 400;
    case C = 100;
    case XC = 90;
    case L = 50;
    case XL = 40;
    case X = 10;
    case IX = 9;
    case V = 5;
    case IV = 4;
    case I = 1;

    public function label(): string
    {
        return match ($this) {
            self::M => 'M',
            self::CM => 'CM',
            self::D => 'D',
            self::CD => 'CD',
            self::C => 'C',
            self::XC => 'XC',
            self::L => 'L',
            self::XL => 'XL',
            self::X => 'X',
            self::IX => 'IX',
            self::V => 'V',
            self::IV => 'IV',
            self::I => 'I',
        };
    }
}

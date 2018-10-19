<?php

namespace Tests;

use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangShortTest extends TestCase
{
    /** @test */
    public function short_method_can_convert_number_to_short_numerals()
    {
        $this->assertEquals('1M', $this->terbilang->short(1000000));
        $this->assertEquals('1k', $this->terbilang->short(1000, 'k'));
        $this->assertEquals('1000M', $this->terbilang->short(1000000000, 'B'));
    }
}

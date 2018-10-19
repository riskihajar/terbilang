<?php

namespace Tests;

use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangRomanTest extends TestCase
{
    /** @test */
    public function roman_method_can_convert_number_to_roman_numerals()
    {
        $this->assertEquals(
            'MCCXXXIV',
            $this->terbilang->roman(1234)
        );
    }

    /** @test */
    public function roman_method_accepts_boolean_argument_for_lowercase_result()
    {
        $this->assertEquals(
            'mccxxxiv',
            $this->terbilang->roman(1234, true)
        );
    }
}

<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangMakeTest extends TestCase
{
    /** @test */
    public function make_method_can_convert_number_to_word()
    {
        $this->assertEquals(
            'one million',
            $this->terbilang->make(1000000)
        );
    }

    /** @test */
    public function make_method_accepts_suffix()
    {
        $this->assertEquals(
            'one million rupiah',
            $this->terbilang->make(1000000, ' rupiah')
        );
    }

    /** @test */
    public function make_method_accepts_prefix()
    {
        $this->assertEquals(
            'Amount: one million rupiah',
            $this->terbilang->make(1000000, ' rupiah', 'Amount: ')
        );
    }
}

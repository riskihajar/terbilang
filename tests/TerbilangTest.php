<?php

namespace Tests;

use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangTest extends TestCase
{
    /** @test */
    public function it_has_facade_accessor()
    {
        $this->assertEquals(Terbilang::make('123'), $this->terbilang->make('123'));
    }
}

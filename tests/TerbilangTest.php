<?php

namespace Tests;

use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangTest extends TestCase
{
    /** @test */
    public function it_has_make_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'make'));
    }

    /** @test */
    public function it_has_short_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'short'));
    }

    /** @test */
    public function it_has_date_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'date'));
    }

    /** @test */
    public function it_has_time_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'time'));
    }

    /** @test */
    public function it_has_datetime_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'datetime'));
    }

    /** @test */
    public function it_has_period_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'period'));
    }

    /** @test */
    public function it_has_roman_method()
    {
        $this->assertTrue(method_exists($this->terbilang, 'roman'));
    }

    /** @test */
    public function it_has_facade_accessor()
    {
        $this->assertEquals(Terbilang::make('123'), $this->terbilang->make('123'));
    }
}

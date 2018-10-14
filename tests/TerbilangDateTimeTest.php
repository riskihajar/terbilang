<?php

namespace Tests;

use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangDateTimeTest extends TestCase
{
    /** @test */
    public function date_method_can_convert_date_to_word()
    {
        $this->assertEquals(
            'thirty-one march two thousand and fifteen',
            $this->terbilang->date('2015-03-31')
        );
    }

    /** @test */
    public function time_method_can_convert_time_to_word()
    {
        $this->assertEquals(
            'ten past fifty-six minutes thirty seconds',
            $this->terbilang->time('10:56:30')
        );
    }

    /** @test */
    public function time_method_can_convert_carbon_time_to_word()
    {
        $this->assertEquals(
            'ten past fifty-six minutes thirty seconds',
            $this->terbilang->time('10:56:30')
        );
    }
    
    /** @test */
    public function datetime_method_can_convert_datetime_to_word()
    {
        $this->assertEquals(
            'thirty-one march two thousand and fifteen at ten past fifty-eight minutes twenty-seven seconds',
            $this->terbilang->datetime('2015-03-31 10:58:27')
        );
    }

    /** @test */
    public function date_time_and_date_time_methods_can_convert_carbon_instance_to_word()
    {
        $carbonDate = \Carbon\Carbon::parse('2015-03-31 10:58:27');

        $this->assertEquals(
            'thirty-one march two thousand and fifteen',
            $this->terbilang->date($carbonDate)
        );

        $this->assertEquals(
            'ten past fifty-eight minutes twenty-seven seconds',
            $this->terbilang->time($carbonDate)
        );

        $this->assertEquals(
            'thirty-one march two thousand and fifteen at ten past fifty-eight minutes twenty-seven seconds',
            $this->terbilang->datetime($carbonDate)
        );
    }
}

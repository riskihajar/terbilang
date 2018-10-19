<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangPeriodTest extends TestCase
{
    /** @test */
    public function period_method_can_convert_number_of_days_periode_to_word()
    {
        $dateToCompare = \Carbon\Carbon::now()->subDays(10)->format('Y-m-d');
        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
        
        $this->assertEquals(
            ' 10 days',
            $this->terbilang->period($dateToCompare, $currentDate)
        );
    }

    /** @test */
    public function period_method_converts_number_of_days_periode_by_today_if_only_one_parameter()
    {
        $date = \Carbon\Carbon::now()->subDays(10)->format('Y-m-d');

        $this->assertEquals(
            ' 10 days',
            $this->terbilang->period($date)
        );
    }

    /** @test */
    public function period_method_converts_time_periode_with_month_format_in_config()
    {
        config(['terbilang.period.type' => 'MONTH']);

        $date = \Carbon\Carbon::now()->subMonths(2)->format('Y-m-d');

        $this->assertEquals(
            ' 2 months',
            $this->terbilang->period($date)
        );
    }
}

<?php

namespace Riskihajar\Terbilang\Commands;

use Illuminate\Console\Command;
use Riskihajar\Terbilang\Enums\LargeNumber;
use Illuminate\Support\Str;

class TerbilangCommand extends Command
{
    public $signature = 'terbilang {number?}';

    public $description = 'My command';

    public function handle(): int
    {
        $number = $this->argument('number');

        $result = app(\Riskihajar\Terbilang\DateTime::class)->datetime('2023-02-18 17:00:00')->dd();

        // $result = \Riskihajar\Terbilang\Facades\Terbilang::largeNumber(
        //     number: $number,
        //     target: LargeNumber::Kilo,
        // )->dd();

        // $result = app(\Riskihajar\Terbilang\NumberToWords::class)->make($number)->dd();

        // Str::of('testing')->prepend('depan', ' ')->dd();

        // dd($result);

        // $ln = \Riskihajar\Terbilang\Enums\LargeNumber::Million;

        // $this->info('ln ' . $ln->divider());

        $this->comment('All done');

        return self::SUCCESS;
    }
}

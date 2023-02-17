<?php

namespace Riskihajar\Terbilang\Commands;

use Illuminate\Console\Command;
use Riskihajar\Terbilang\Enums\LargeNumber;

class TerbilangCommand extends Command
{
    public $signature = 'terbilang {number?}';

    public $description = 'My command';

    public function handle(): int
    {
        $number = $this->argument('number');

        $result = \Riskihajar\Terbilang\Facades\Terbilang::largeNumber(
            number: $number,
            target: LargeNumber::Kilo,
        );

        dd($result);

        // $ln = \Riskihajar\Terbilang\Enums\LargeNumber::Million;

        // $this->info('ln ' . $ln->divider());

        $this->comment('All done');

        return self::SUCCESS;
    }
}

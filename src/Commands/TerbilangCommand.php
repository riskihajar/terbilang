<?php

namespace Riskihajar\Terbilang\Commands;

use Illuminate\Console\Command;

class TerbilangCommand extends Command
{
    public $signature = 'terbilang {number?}';

    public $description = 'My command';

    public function handle(): int
    {
        $number = $this->argument('number');

        $result = \Riskihajar\Terbilang\Facades\Terbilang::roman($number);

        dd($result->lower());

        // $ln = \Riskihajar\Terbilang\Enums\LargeNumber::Million;

        // $this->info('ln ' . $ln->divider());

        $this->comment('All done');

        return self::SUCCESS;
    }
}

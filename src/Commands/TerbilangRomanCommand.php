<?php

namespace Riskihajar\Terbilang\Commands;

use Illuminate\Console\Command;
use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangRomanCommand extends Command
{
    public $signature = 'terbilang:roman {number}';

    public $description = 'Convert Number to Roman';

    public function handle(): int
    {
        $number = $this->argument('number');
        $result = Terbilang::roman($number);

        $this->output->writeln("$number : <info>$result</info>");

        return self::SUCCESS;
    }
}

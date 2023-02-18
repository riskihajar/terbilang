<?php

namespace Riskihajar\Terbilang\Commands;

use Illuminate\Console\Command;
use Riskihajar\Terbilang\Enums\LargeNumber;
use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangLargeNumberCommand extends Command
{
    public $signature = 'terbilang:ln {number} {target?}';

    public $description = 'Convert Number to Large Number Short Label';

    public function handle(): int
    {
        $number = $this->argument('number');
        $target = $this->argument('target') ?: 'kilo';

        $target = LargeNumber::from($target);

        $result = Terbilang::largeNumber(number: $number, target: $target);

        $this->output->writeln("$number : <info>$result</info>");

        return self::SUCCESS;
    }
}

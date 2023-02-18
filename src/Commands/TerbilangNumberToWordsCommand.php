<?php

namespace Riskihajar\Terbilang\Commands;

use Illuminate\Console\Command;
use Riskihajar\Terbilang\Facades\Terbilang;

class TerbilangNumberToWordsCommand extends Command
{
    public $signature = 'terbilang:word {number}';

    public $description = 'Convert Number to Words (terbilang)';

    public function handle(): int
    {
        $number = $this->argument('number');
        $result = Terbilang::make($number, ' rupiah', ' senilai');

        $this->output->writeln("$number : <info>$result</info>");

        return self::SUCCESS;
    }
}

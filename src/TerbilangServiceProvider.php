<?php

namespace Riskihajar\Terbilang;

use Riskihajar\Terbilang\Commands\TerbilangLargeNumberCommand;
use Riskihajar\Terbilang\Commands\TerbilangNumberToWordsCommand;
use Riskihajar\Terbilang\Commands\TerbilangRomanCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TerbilangServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('terbilang')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasCommands(
                TerbilangNumberToWordsCommand::class,
                TerbilangRomanCommand::class,
                TerbilangLargeNumberCommand::class,
            );
    }
}

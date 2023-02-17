<?php

namespace Riskihajar\Terbilang;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Riskihajar\Terbilang\Commands\TerbilangCommand;

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
            ->hasViews()
            ->hasMigration('create_terbilang_table')
            ->hasCommand(TerbilangCommand::class);
    }
}

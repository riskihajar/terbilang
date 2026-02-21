<?php

namespace Riskihajar\Terbilang;

use Illuminate\Support\ServiceProvider;
use Riskihajar\Terbilang\Commands\TerbilangLargeNumberCommand;
use Riskihajar\Terbilang\Commands\TerbilangNumberToWordsCommand;
use Riskihajar\Terbilang\Commands\TerbilangRomanCommand;

class TerbilangServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/terbilang.php',
            'terbilang'
        );
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'terbilang');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/terbilang.php' => config_path('terbilang.php'),
            ], 'terbilang-config');

            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/terbilang'),
            ], 'terbilang-translations');

            $this->commands([
                TerbilangNumberToWordsCommand::class,
                TerbilangRomanCommand::class,
                TerbilangLargeNumberCommand::class,
            ]);
        }
    }
}

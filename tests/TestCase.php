<?php

namespace Riskihajar\Terbilang\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Riskihajar\Terbilang\Terbilang;
use Riskihajar\Terbilang\TerbilangServiceProvider;

class TestCase extends Orchestra
{
    protected $terbilang;

    protected function setUp(): void
    {
        parent::setUp();

        $this->terbilang = new Terbilang;
    }

    protected function getPackageProviders($app)
    {
        return [
            TerbilangServiceProvider::class,
        ];
    }
}

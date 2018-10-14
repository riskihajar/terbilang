<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Riskihajar\Terbilang\Terbilang;
use Riskihajar\Terbilang\TerbilangServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected $terbilang;

    protected function setUp()
    {
        parent::setUp();
        $this->terbilang = new Terbilang();
    }

    protected function getPackageProviders($app)
    {
        return [TerbilangServiceProvider::class];
    }
}

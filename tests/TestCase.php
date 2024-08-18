<?php

namespace JesseSchutt\TokenReplacer\Tests;

use JesseSchutt\TokenReplacer\ServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'TokenReplacer' => '\JesseSchutt\TokenReplacer\Facades\TokenReplacer',
        ];
    }
}

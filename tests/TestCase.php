<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!app()->environment('testing')) {
            return;
        }

        $defaultConnection = (string) config('database.default');
        $databaseName = config("database.connections.{$defaultConnection}.database");

        if ($defaultConnection === 'sqlite' || $databaseName === ':memory:') {
            return;
        }

        $databaseName = (string) $databaseName;
        $lower = strtolower($databaseName);

        if ($databaseName !== '' && !str_contains($lower, 'test')) {
            throw new \RuntimeException(
                "Refusing to run tests against database [{$databaseName}]. " .
                    'Configure a dedicated testing DB via phpunit.xml or .env.testing (e.g. *_testing).'
            );
        }
    }
}

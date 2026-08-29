<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $application = parent::createApplication();
        $config = $application->make('config');

        if (! $application->environment('testing')
            || $config->get('database.default') !== 'sqlite'
            || $config->get('database.connections.sqlite.database') !== ':memory:') {
            throw new RuntimeException(
                'Test safety check failed: clear cached configuration and use the in-memory SQLite testing database.',
            );
        }

        return $application;
    }
}

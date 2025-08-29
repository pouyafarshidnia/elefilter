<?php

declare(strict_types=1);

namespace Tests;

use EleFilter\EleFilterServiceProvider;
use Orchestra\Testbench\TestCase;


class EleFilterTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            EleFilterServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('elefilter.namespace', 'Tests\\Support\\Filters');
        $app['config']->set('elefilter.path', 'tests/Support/Filters');
        $app['config']->set('elefilter.full_path', 'tests/Support/Filters');
    }
}

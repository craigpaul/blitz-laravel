<?php

namespace CraigPaul\Blitz\Tests;

use CraigPaul\Blitz\BlitzServiceProvider;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Storage::build($this->app->basePath('tests/Blitz'))->put('ExampleTest.php', file_get_contents(__DIR__ . '/stubs/ExampleTest.php.stub'));
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Storage::build($this->app->basePath('tests'))->deleteDirectory('Blitz');

        parent::tearDown();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [BlitzServiceProvider::class];
    }
}

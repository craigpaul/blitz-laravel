<?php

namespace CraigPaul\Blitz\Tests;

class CanAddStubbedTestFileViaCommandTest extends TestCase
{
    public function testCanAddStubbedTestFileWhenSupplyingTestNameSuccessfully()
    {
        $this->artisan('blitz:make ExampleLoadTest')->assertOk();

        $this->assertFileExists($this->app->basePath('tests/Blitz/ExampleLoadTest.php'));
    }

    public function testCanAddStubbedTestFileWhenAskedForTestNameSuccessfully()
    {
        if (version_compare($this->app->version(), '9.49', '<')) {
            return $this->markTestSkipped('Prompting for missing input was not available until Laravel v9.49.0');
        }

        $this->artisan('blitz:make')->expectsQuestion('What should the test be named?', 'AnotherExampleLoadTest')->assertOk();

        $this->assertFileExists($this->app->basePath('tests/Blitz/AnotherExampleLoadTest.php'));
    }
}

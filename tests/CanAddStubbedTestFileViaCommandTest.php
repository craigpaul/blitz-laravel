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
        $this->artisan('blitz:make')->expectsQuestion('What should the test be named?', 'AnotherExampleLoadTest')->assertOk();

        $this->assertFileExists($this->app->basePath('tests/Blitz/AnotherExampleLoadTest.php'));
    }
}

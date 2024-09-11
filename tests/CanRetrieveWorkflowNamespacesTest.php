<?php

namespace CraigPaul\Blitz\Tests;

use Illuminate\Testing\Fluent\AssertableJson;
use Mockery\MockInterface;

class CanRetrieveWorkflowNamespacesTest extends TestCase
{
    public function testCanRetrieveExistingWorkflowNamespaces()
    {
        $this->withoutExceptionHandling()
            ->getJson(route('blitz.workflows'))
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJson(fn (AssertableJson $json) => $json->where('0', [
                'fields' => [],
                'namespace' => 'Tests\\Blitz\\ExampleTest',
            ]));
    }

    public function testCanSupplyOptionsWithWorkflows()
    {
        $this->artisan('make:blitz ExampleOptionableLoadTest --fields')->assertOk();

        $this->mock('Tests\\Blitz\\ExampleOptionableLoadTest', function (MockInterface $mock) {
            return $mock->shouldReceive('fields')
                ->andReturn([
                    'foo' => 'bar',
                ])
                ->getMock();
        });

        $this->withoutExceptionHandling()
            ->getJson(route('blitz.workflows'))
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJson(fn (AssertableJson $json) => $json->where('0', [
                'fields' => [
                    'foo' => 'bar',
                ],
                'namespace' => 'Tests\\Blitz\\ExampleOptionableLoadTest',
            ]));
    }
}

<?php

namespace CraigPaul\Blitz\Tests;

use Illuminate\Testing\Fluent\AssertableJson;
use Mockery\MockInterface;

class CanGenerateTargetsFromWorkflowNamespaceTest extends TestCase
{
    public function testCanGenerateTargetsFromAnExistingWorkflowNamespace()
    {
        $namespace = 'Tests\\Blitz\\ExampleTest';

        $response = [1, 2, 3];

        $this->mock($namespace, function (MockInterface $mock) use ($response) {
            $mock = $mock->makePartial()
                ->shouldReceive('handle')
                ->andReturnSelf()
                ->getMock();

            $mock->shouldReceive('getBuckets')->andReturn(null);
            $mock->shouldReceive('getTargets')->andReturn($response);

            return $mock;
        });

        $this->withoutExceptionHandling()
            ->postJson(route('blitz.targets'), [
                'namespace' => $namespace,
            ])
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('buckets', null)->where('targets', $response),
            );
    }
}

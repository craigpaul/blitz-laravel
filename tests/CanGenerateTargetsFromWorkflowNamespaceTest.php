<?php

namespace CraigPaul\Blitz\Tests;

use Mockery\MockInterface;

class CanGenerateTargetsFromWorkflowNamespaceTest extends TestCase
{
    public function testCanGenerateTargetsFromAnExistingWorkflowNamespace()
    {
        $namespace = 'Tests\\Blitz\\ExampleTest';

        $response = [1, 2, 3];

        $this->mock($namespace, function (MockInterface $mock) use ($response) {
            return $mock->makePartial()
                ->shouldReceive('setUp')
                ->andReturnSelf()
                ->getMock()
                ->shouldReceive('getTargets')
                ->andReturn($response);
        });

        $this->withoutExceptionHandling()
            ->postJson(route('blitz.targets'), [
                'namespace' => $namespace,
            ])
            ->assertOk()
            ->assertJson($response);
    }
}

<?php

namespace CraigPaul\Blitz\Tests;

use Illuminate\Testing\Fluent\AssertableJson;

class CanRetrieveWorkflowNamespacesTest extends TestCase
{
    public function testCanRetrieveExistingWorkflowNamespaces()
    {
        $this->withoutExceptionHandling()
            ->getJson(route('blitz.workflows'))
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJson(fn (AssertableJson $json) => $json->where('0', 'Tests\\Blitz\\ExampleTest'));
    }
}

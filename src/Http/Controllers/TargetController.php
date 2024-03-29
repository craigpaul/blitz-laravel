<?php

namespace CraigPaul\Blitz\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TargetController
{
    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     *
     * @return void
     */
    public function __construct(
        protected Application $app,
        protected ResponseFactory $response,
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $instance = $this->app->make($request->post('namespace'));

        $instance->handle();

        return $this->response->json($instance->getTargets());
    }
}

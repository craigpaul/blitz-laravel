<?php

namespace CraigPaul\Blitz\Http\Controllers;

use CraigPaul\Blitz\Support\Workflow;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SplFileInfo;

class WorkflowController
{
    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Filesystem\FilesystemManager $filesystem
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     *
     * @return void
     */
    public function __construct(
        protected Application $app,
        protected Factory $filesystem,
        protected ResponseFactory $response,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $directory = $this->app->basePath('tests/Blitz');

        $files = array_map(
            fn (string $file) => new SplFileInfo($directory . '/' . $file),
            array_values(
                array_filter(
                    $this->filesystem->build($directory)->allFiles(),
                    fn (string $file) => str_ends_with($file, 'Test.php'),
                ),
            ),
        );

        $workflows = array_map(function (SplFileInfo $file) use ($request) {
            $workflow = Workflow::fromFile($file);
            $namespace = $workflow->className;
            $fields = $workflow->customizable
                ? $this->app->make($namespace)->fields($request)
                : [];

            return [
                'fields' => $fields,
                'namespace' => $namespace,
            ];
        }, $files);

        return $this->response->json($workflows);
    }
}

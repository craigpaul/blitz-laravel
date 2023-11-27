<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Blitz Master Switch
    |--------------------------------------------------------------------------
    |
    | This option may be used to disable all Blitz endpoints, which simply
    | provides a single and convenient way to enable or disable access
    | to your load testing workflows and the ability to generate
    | the targets necessary to run those workflows.
    |
    */

    'enabled' => env('BLITZ_ENABLED', false),

];

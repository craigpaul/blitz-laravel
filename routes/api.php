<?php

use CraigPaul\Blitz\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('_blitz/workflows')->name('blitz.workflows')->uses([Controllers\WorkflowController::class, 'index']);
Route::post('_blitz/targets')->name('blitz.targets')->uses([Controllers\TargetController::class, 'store']);

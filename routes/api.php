<?php

use Dedecube\Profile\Http\Controllers\PasswordUpdateController;
use Dedecube\Profile\Http\Controllers\UserDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/user', UserDetailController::class);

Route::post('/password', PasswordUpdateController::class);

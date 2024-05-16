<?php

use Illuminate\Support\Facades\Route;
use Kra8\Snowflake\Snowflake;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return app(Snowflake::class)->id();
});

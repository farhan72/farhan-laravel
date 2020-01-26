<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
$nameSpace = 'V1\User';
Route::namespace($nameSpace)->group(function () {
    Route::post('v1/user/register', 'AuthController@register');
    Route::post('v1/user/login', 'AuthController@login');
});

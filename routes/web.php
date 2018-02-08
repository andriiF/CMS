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
    return view('frontend.welcome');
});
Route::get('/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::group(['middleware' => 'web'], function () {
    Route::auth();

});

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
Route::group(['namespace' => 'Admin', 'prefix' => '/admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'AdminHomePageController@index')->name('admin.home');
    Route::get('/home', 'AdminController@index');
});
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'BlogsController@index');
Route::get('/home','BlogsController@index');
Route::resource('blogs','BlogsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::get('/api/get/{id}','ApiController@get');

Route::Post('api/stored','ApiController@stored');


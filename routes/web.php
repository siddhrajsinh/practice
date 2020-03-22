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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/visitors', 'VisitorController@index')->name('visitor');
Route::post('/visitor-list', 'VisitorController@getVisitorList')->name('visitor.list');
Route::post('/visitor-export', 'VisitorController@export')->name('visitor.export');

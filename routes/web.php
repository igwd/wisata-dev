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


Route::get('/','HomeController@index');
Auth::routes();
Route::get('/gallery',function(){
	return view('site.gallery');
})->name('gallery');

Route::get('/home', 'HomeController@index');

//role admin route
Route::group(['middleware' => 'auth','RoleAccess:1'], function () {
	Route::get('admin', 'Admin\DashboardController@index')->name('admin');
});

//role user route
Route::group(['middleware' => 'auth','RoleAccess:2'], function () {
	Route::get('/home', 'HomeController@index')->name('home');
});

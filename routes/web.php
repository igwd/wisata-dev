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

Auth::routes([
  'register' => false,
  'reset' => false,
  'verify' => false,
]);

Route::get('/','HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gallery',function(){
	return view('site.gallery');
})->name('gallery');

Route::get('/tiket',function(){
	return view('site.tiket');
})->name('tiket');


//role admin route
Route::group(['middleware' => 'auth'], function () {
	//dashboard-start
	Route::get('admin', 'Admin\DashboardController@index')->name('admin');
	Route::get('admin/listDataHalaman', 'Admin\DashboardController@listDataHalaman')->name('listDataHalaman');
	//edit halaman web
	Route::get( 'admin/{param1}/edithalaman','Admin\DashboardController@edit')->name('admin.edithalaman');
	Route::put( 'admin/updatehalaman/{param1}','Admin\DashboardController@update')->name('admin.updatehalaman');
	//edit halaman web end
	//slideshow
	Route::get('admin/listDataSlideShow', 'Admin\SlideShowController@listDataSlideShow')->name('listDataSlideShow');
	Route::get( 'admin/slideshow/{param1}/edit','Admin\SlideShowController@edit')->name('admin.slideshow.edit');
	Route::put( 'admin/slideshow/{param1}/update','Admin\SlideShowController@update')->name('admin.slideshow.update');
	//slideshow end
	//dashboard-end
});


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

Route::get('galeri/photo', 'GaleriController@photo', function () {
    return Galeri::paginate();
})->name('galeri.photo');

Route::get('galeri/video', 'GaleriController@video', function () {
    return Galeri::paginate();
})->name('galeri.video');

Route::get('fasilitas/{param1}', 'FasilitasController@view', function () {
    return Fasilitas::paginate();
})->name('fasilitas.view');

Route::get('fasilitas/{param1}/popular', 'FasilitasController@popular')->name('fasilitas.view');

Route::get('fasilitas/{param1}/{param2}/detail', 'FasilitasController@show')->name('fasilitas.show');

Route::get('/tiket/howto','TiketController@index')->name('tiket');
Route::get('/tiket','TiketController@create')->name('tiket.order');
Route::post('/tiket/pesan','TiketController@store')->name('tiket.order');
Route::get('/tiket/show/{param}','TiketController@show')->name('tiket.view');
Route::get('/tiket/{param}/verifikasi','TiketController@verifikasi')->name('tiket.verify');

Route::post('/book/addtocart','BookingController@addToCart')->name('booking.addtocart');
Route::get('/book/getcartitem','BookingController@getCartItem')->name('booking.getcartitem');


//role admin route
Route::group(['middleware' => 'auth'], function () {
	//dashboard-start
	Route::get('admin', 'Admin\DashboardController@index')->name('admin.dashboard');
	Route::get('admin/listDataHalaman', 'Admin\DashboardController@listDataHalaman')->name('listDataHalaman');
	//edit halaman web
	Route::get( 'admin/{param1}/edithalaman','Admin\DashboardController@edit')->name('admin.edithalaman');
	Route::put( 'admin/updatehalaman/{param1}','Admin\DashboardController@update')->name('admin.updatehalaman');
	//edit halaman web end
	//slideshow
	Route::get('admin/listDataSlideShow', 'Admin\SlideShowController@listDataSlideShow')->name('listDataSlideShow');
	Route::get( 'admin/slideshow/{param1}/edit','Admin\SlideShowController@edit')->name('admin.slideshow.edit');
	Route::put( 'admin/slideshow/{param1}/update','Admin\SlideShowController@update')->name('admin.slideshow.update');
	Route::get( 'admin/slideshow/create','Admin\SlideShowController@create')->name('admin.slideshow.create');
	Route::put( 'admin/slideshow/store','Admin\SlideShowController@store')->name('admin.slideshow.store');
	Route::delete('admin/slideshow/{param1}/destroy','Admin\SlideShowController@destroy')->name('admin.slideshow.destroy');
	//slideshow end
	//dashboard-end
	//admin-fasilitas-start
	//admin-fasilitas-tempatmakan-start
	Route::get('admin/fasilitas/tempatmakan', 'Admin\Fasilitas\TempatMakanController@index')->name('admin.fasilitas.tempatmakan');
	Route::get('admin/fasilitas/tempatmakan/listData', 'Admin\Fasilitas\TempatMakanController@listData')->name('admin.fasilitas.tempatmakan.listData');
	Route::get( 'admin/fasilitas/tempatmakan/{param1}/edit','Admin\Fasilitas\TempatMakanController@edit')->name('admin.fasilitas.tempatmakan.edit');
	Route::put( 'admin/fasilitas/tempatmakan/{param1}/update','Admin\Fasilitas\TempatMakanController@update')->name('admin.fasilitas.tempatmakan.update');
	Route::get( 'admin/fasilitas/tempatmakan/create','Admin\Fasilitas\TempatMakanController@create')->name('admin.fasilitas.tempatmakan.create');
	Route::put( 'admin/fasilitas/tempatmakan/store','Admin\Fasilitas\TempatMakanController@store')->name('admin.fasilitas.tempatmakan.store');
	Route::delete('admin/fasilitas/tempatmakan/{param1}/destroy','Admin\Fasilitas\TempatMakanController@destroy')->name('admin.fasilitas.tempatmakan.destroy');
	//admin-fasilitas-tempatmakan-end
	//admin-fasilitas-penginapan-start
	Route::get('admin/fasilitas/penginapan', 'Admin\Fasilitas\PenginapanController@index')->name('admin.fasilitas.penginapan');
	Route::get('admin/fasilitas/penginapan/listData', 'Admin\Fasilitas\PenginapanController@listData')->name('admin.fasilitas.penginapan.listData');
	Route::get( 'admin/fasilitas/penginapan/{param1}/edit','Admin\Fasilitas\PenginapanController@edit')->name('admin.fasilitas.penginapan.edit');
	Route::put( 'admin/fasilitas/penginapan/{param1}/update','Admin\Fasilitas\PenginapanController@update')->name('admin.fasilitas.penginapan.update');
	Route::get( 'admin/fasilitas/penginapan/create','Admin\Fasilitas\PenginapanController@create')->name('admin.fasilitas.penginapan.create');
	Route::put( 'admin/fasilitas/penginapan/store','Admin\Fasilitas\PenginapanController@store')->name('admin.fasilitas.penginapan.store');
	Route::delete('admin/fasilitas/penginapan/{param1}/destroy','Admin\Fasilitas\PenginapanController@destroy')->name('admin.fasilitas.penginapan.destroy');
	//admin-fasilitas-penginapan-end
	//admin-fasilitas-penginapan-start
	Route::get('admin/fasilitas/transportasi', 'Admin\Fasilitas\TransportasiController@index')->name('admin.fasilitas.transportasi');
	Route::get('admin/fasilitas/transportasi/listData', 'Admin\Fasilitas\TransportasiController@listData')->name('admin.fasilitas.transportasi.listData');
	Route::get( 'admin/fasilitas/transportasi/{param1}/edit','Admin\Fasilitas\TransportasiController@edit')->name('admin.fasilitas.transportasi.edit');
	Route::put( 'admin/fasilitas/transportasi/{param1}/update','Admin\Fasilitas\TransportasiController@update')->name('admin.fasilitas.transportasi.update');
	Route::get( 'admin/fasilitas/transportasi/create','Admin\Fasilitas\TransportasiController@create')->name('admin.fasilitas.transportasi.create');
	Route::put( 'admin/fasilitas/transportasi/store','Admin\Fasilitas\TransportasiController@store')->name('admin.fasilitas.transportasi.store');
	Route::delete('admin/fasilitas/transportasi/{param1}/destroy','Admin\Fasilitas\TransportasiController@destroy')->name('admin.fasilitas.transportasi.destroy');
	//admin-fasilitas-penginapan-end
	//admin-fasilitas-end
	//admin-galeri-photo-start
	Route::get('admin/galeri/photo', function () {
	    return Galeri::paginate();
	});
	Route::get('admin/galeri/photo', 'Admin\Galeri\PhotoController@index')->name('admin.galeri.photo');
	Route::get( 'admin/galeri/photo/{param1}/edit','Admin\Galeri\PhotoController@edit')->name('admin.galeri.photo.edit');
	Route::put( 'admin/galeri/photo/{param1}/update','Admin\Galeri\PhotoController@update')->name('admin.galeri.photo.update');
	Route::get( 'admin/galeri/photo/create','Admin\Galeri\PhotoController@create')->name('admin.galeri.photo.create');
	Route::put( 'admin/galeri/photo/store','Admin\Galeri\PhotoController@store')->name('admin.galeri.photo.store');
	Route::delete('admin/galeri/photo/{param1}/destroy','Admin\Galeri\PhotoController@destroy')->name('admin.galeri.photo.destroy');
	//admin-galeri-photo-end

	//admin-galeri-video-start
	Route::get('admin/galeri/video', function () {
	    return Galeri::paginate();
	});
	Route::get('admin/galeri/video', 'Admin\Galeri\VideoController@index')->name('admin.galeri.video');
	Route::get( 'admin/galeri/video/{param1}/edit','Admin\Galeri\VideoController@edit')->name('admin.galeri.video.edit');
	Route::put( 'admin/galeri/video/{param1}/update','Admin\Galeri\VideoController@update')->name('admin.galeri.video.update');
	Route::get( 'admin/galeri/video/create','Admin\Galeri\VideoController@create')->name('admin.galeri.video.create');
	Route::put( 'admin/galeri/video/store','Admin\Galeri\VideoController@store')->name('admin.galeri.video.store');
	Route::delete('admin/galeri/video/{param1}/destroy','Admin\Galeri\VideoController@destroy')->name('admin.galeri.video.destroy');
	//admin-galeri-video-end
});


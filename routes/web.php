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

Route::get('/term', 'HomeController@term')->name('termofuse');

Route::get('galeri/photo', 'GaleriController@photo', function () {
    return Galeri::paginate();
})->name('galeri.photo');

Route::get('galeri/video', 'GaleriController@video', function () {
    return Galeri::paginate();
})->name('galeri.video');

// route fasilitas start 
Route::get('fasilitas/{param1}', 'FasilitasController@view', function () {
    return Fasilitas::paginate();
})->name('fasilitas.view');
/*
	Controller 	: app/Http/Controller => FasilitasController
	Fungsi 		: view($kategori)
	Parameter 	: $kategori = 'transportasi' atau 'kuliner' atau 'penginapan'
	Fungsi		: menampilkan data fasilitas berdasarkan kategori
*/

Route::get('fasilitas/{param1}/popular', 'FasilitasController@popular')->name('fasilitas.view');
/*
	Controller 	: app/Http/Controller => FasilitasController
	Fungsi 		: popular()
	Parameter 	: $kategori = 'transportasi' atau 'kuliner' atau 'penginapan'
	Fungsi		: menampilkan list fasilitas yg paling populer berdasarkan rating yg diberikan pengunjung
*/

Route::get('fasilitas/{param1}/{param2}/detail', 'FasilitasController@show')->name('fasilitas.show');
/*
	Controller 	: app/Http/Controller => FasilitasController
	Fungsi 		: show($kategori)
	Parameter 	: $kategori = 'transportasi' atau 'kuliner' atau 'penginapan'
	Fungsi		: menampilkan list fasilitas yg paling populer berdasarkan rating yg diberikan pengunjung
*/

Route::get('fasilitas/rating/{param1}', 'FasilitasController@showModalRating')->name('fasilitas.rating.form');
/*
	Controller 	: app/Http/Controller => FasilitasController
	Fungsi 		: showModalRating()
	Parameter 	: $kategori, $id
	Fungsi		: menampilkan form untuk memberikan rating fasilitas dari pengunjung
*/
Route::post('fasilitas/rating/store', 'FasilitasController@submitRating')->name('fasilitas.rating.submit');
/*
	Controller 	: app/Http/Controller => FasilitasController
	Fungsi 		: showModalRating()
	Parameter 	: $kategori, $id
	Fungsi		: simpan rating user
*/	

//route fasilitas end

// untuk pemesanan tiket
Route::get('/tiket','TiketController@index')->name('tiket');
Route::get('/tiket/check/','TiketController@check')->name('tiket.check');
Route::get('/tiket/check/{param1}','TiketController@check')->name('tiket.check-kode');
Route::get('/tiket/{param}/cetak','TiketController@cetak')->name('tiket.cetak');
// pemesanan tiket end

// untuk proses booking
Route::get('/booking/cart','BookingController@index')->name('booking.cart');
Route::post('/booking/proses','BookingController@store')->name('booking.order');
Route::post('/booking/addtocart','BookingController@addToCart')->name('booking.addtocart');
Route::post('/booking/addtikettocart','BookingController@addTiketToCart')->name('booking.addtikettocart');
Route::get('/booking/getcartitem','BookingController@getCartItem')->name('booking.getcartitem');
Route::get('/booking/{param}/verifikasi','BookingController@verifikasi')->name('booking.verifikasi');

Route::get('/booking/{param}/payment','BookingController@payment')->name('booking.payment');
Route::put('/booking/{param}/upload','BookingController@upload')->name('booking.uploadbukti');
//booking end
//role admin route
Route::group(['middleware' => 'auth'], function () {
	//dashboard-start
	Route::get('admin/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
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
	Route::post( 'admin/galeri/video/store','Admin\Galeri\VideoController@store')->name('admin.galeri.video.store');
	Route::delete('admin/galeri/video/{param1}/destroy','Admin\Galeri\VideoController@destroy')->name('admin.galeri.video.destroy');
	//admin-galeri-video-end

	//admin-tiket
	Route::get('admin/tiket/transaksi', 'Admin\TiketController@indexTransaksi')->name('admin.tiket.transaksi');
	
	Route::get('admin/tiket/buktibayar', 'Admin\TiketController@index')->name('admin.tiket.buktibayar');
	Route::get('admin/tiket/buktibayar/listData', 'Admin\TiketController@listData')->name('admin.tiket.buktibayar.listData');
	Route::get('admin/tiket/buktibayar/formUploadBuktiBayar', 'Admin\TiketController@formUploadBuktiBayar')->name('admin.tiket.buktibayar.form');
	Route::put('admin/tiket/buktibayar/{param1}/approveBuktiBayar','Admin\TiketController@approveBuktiBayar')->name('admin.tiket.buktibayar.approveBuktiBayar');
	Route::delete('admin/tiket/buktibayar/{param1}/destroy','Admin\TiketController@destroy')->name('admin.tiket.buktibayar.destroy');

	Route::get('admin/tiket/cetak', 'Admin\TiketController@indexCetak')->name('admin.tiket.cetak');
	Route::get('admin/tiket/cetak/listDataCetakTiket', 'Admin\TiketController@listDataCetakTiket')->name('admin.tiket.cetak.listDataCetakTiket');
	

	Route::get('admin/tiket/setting', 'Admin\TiketController@indexSettingTiket')->name('admin.tiket.setting');
	Route::get('admin/tiket/setting/listDataMasterTiket', 'Admin\TiketController@listDataMasterTiket')->name('admin.tiket.setting.listData');
	Route::get( 'admin/tiket/setting/{param1}/edit','Admin\TiketController@editMasterTiket')->name('admin.tiket.setting.edit');
	Route::put( 'admin/tiket/setting/{param1}/update','Admin\TiketController@updateMasterTiket')->name('admin.tiket.setting.update');
	Route::get( 'admin/tiket/setting/create','Admin\TiketController@createMasterTiket')->name('admin.tiket.setting.create');
	Route::post( 'admin/tiket/setting/store','Admin\TiketController@storeMasterTiket')->name('admin.tiket.setting.store');
	Route::delete('admin/tiket/setting/{param1}/destroy','Admin\TiketController@destroyMasterTiket')->name('admin.tiket.setting.destroy');
	Route::get('admin/tiket/listDataFasilitas', 'Admin\TiketController@listDataFasilitas')->name('admin.tiket.fasilitas.listData');
	Route::get('admin/tiket/modalDataFasilitas', 'Admin\TiketController@modalDataFasilitas')->name('admin.tiket.modal.fasilitas');
	Route::post('admin/tiket/proses','Admin\TiketController@store')->name('admin.tiket.order');
	//end admmin-tiket

	//start-admin-grafik
	Route::get('admin/grafik', 'Admin\GrafikController@index')->name('admin.grafik');
	Route::get('admin/grafik/kunjungan', 'Admin\GrafikController@dataKunjungan')->name('admin.grafik.kunjungan');
	//end-admin-grafik

	Route::get('admin/account','Admin\AccountController@index')->name('admin.account');
	Route::get('admin/account/listData','Admin\AccountController@listData')->name('admin.account.list');
	Route::get( 'admin/account/{param1}/edit','Admin\AccountController@edit')->name('admin.account.edit');
	Route::put( 'admin/account/{param1}/update','Admin\AccountController@update')->name('admin.account.update');
	Route::get( 'admin/account/create','Admin\AccountController@create')->name('admin.account.create');
	Route::post( 'admin/account/store','Admin\AccountController@store')->name('admin.account.store');
	Route::delete('admin/account/{param1}/destroy','Admin\AccountController@destroy')->name('admin.account.destroy');
	//update password
	Route::get( 'admin/account/{param1}/resetpassword','Admin\AccountController@resetPassword')->name('admin.account.reset');
	Route::put( 'admin/account/{param1}/updatepassword','Admin\AccountController@updatePassword')->name('admin.account.updatepassword');
});


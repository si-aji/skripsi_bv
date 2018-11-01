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

Route::group(['middleware' => ['auth','web',]], function(){
    //Staff
    Route::get('/staff', function(){
        return view('staff.dashboard.index');
    })->name('staff');

    //Kategori
    Route::resource('/staff/kategori', 'KategoriController');
    Route::get('/data/kategori/{id}', 'KategoriController@kategoriSpecificJson'); //Data Kategori
    Route::get('/list/kategori', 'KategoriController@kategoriAllJson'); //List Kategori

    //Barang
    Route::resource('/staff/barang', 'BarangController');
    Route::get('/list/barang', 'BarangController@barangJson'); //List Barang (All)
    Route::get('/data/barang/{id}', 'BarangController@barangSpecificJson'); //Data Barang
    Route::get('/data/barang/kategori/{id}', 'BarangController@kategoriSpecificJson'); //Data Barang

});


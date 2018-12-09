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

Auth::routes(['register' => false]);

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
    Route::get('/data/barang/select', 'BarangController@barangSelectTwoJson'); //Select 2 Barang
    Route::get('/data/barang/{id}', 'BarangController@barangSpecificJson'); //Data Barang
    Route::get('/data/barang/kategori/{id}', 'BarangController@kategoriSpecificJson'); //Data Barang

    //Paket
    Route::resource('/staff/paket', 'PaketController');
    Route::get('/list/paket', 'PaketController@paketJson');
    Route::get('/data/paket/select', 'PaketController@paketSelectTwoJson'); //Select 2 Paket
    Route::get('/data/paket/{id}', 'PaketController@paketSpecificJson'); //Data Paket


    //Kostumer
    Route::resource('/staff/kostumer', 'KostumerController');
    Route::get('/list/kostumer', 'KostumerController@kostumerJson'); //List Kostumer (All)

    //Supplier
    Route::resource('/staff/supplier', 'SupplierController');
    Route::get('/list/supplier', 'SupplierController@supplierJson'); //List Supplier (All)

    //Karyawan
    Route::resource('/staff/karyawan', 'UserController');
    Route::get('/list/karyawan', 'UserController@userJson'); //List Toko (All)
    Route::get('/staff/profile', 'UserController@profile'); //Profile
    Route::put('/staff/profile/update/{karyawan}', 'UserController@profileUpdate'); //Profile Update

    //Toko
    Route::resource('/staff/toko', 'TokoController');
    Route::get('/list/toko', 'TokoController@tokoJson'); //List Toko (All)
    Route::post('/list/toko', 'TokoController@tokoTipeJson'); //List Toko (by List)

    // Transaksi
    //Penjualan
    Route::resource('/staff/penjualan', 'PenjualanController');
    Route::get('/staff/penjualan/invoice/{invoice}', 'PenjualanController@show');
    Route::get('/list/penjualan', 'PenjualanController@penjualanJson'); //List Penjualan (All)
    Route::post('/list/penjualan', 'PenjualanController@penjualanFilterJson'); //List Penjualan (with Filter)
    Route::post('/list/penjualan/date', 'PenjualanController@penjualanDateBasedJson'); //List Penjualan (Based on Date)
    //Apriori
    Route::post('/penjualan/apriori', 'AprioriController@cSatu');
    Route::post('/penjualan/apriori/dua', 'AprioriController@cDua');
    Route::post('/penjualan/apriori/tiga', 'AprioriController@cTiga');
    //Apriori - Conf
    Route::post('/penjualan/apriori/conf/dua', 'AprioriController@getTwoConf');
    Route::post('/penjualan/apriori/conf/tiga', 'AprioriController@getThreeConf');


    //Pembelian
    Route::resource('/staff/pembelian', 'PembelianController');
    Route::get('/staff/pembelian/invoice/{invoice}', 'PembelianController@show');
    Route::get('/list/pembelian', 'PembelianController@pembelianJson'); //List Pembelian (All)

    // Analisa
    //Apriori
    Route::get('/staff/analisa/apriori', function(){
        return view('staff.analisa.apriori.apriori');
    });
});


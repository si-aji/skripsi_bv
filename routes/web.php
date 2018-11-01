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

    Route::resource('/staff/kategori', 'KategoriController'); //Kategori
    Route::get('/list/kategori', 'KategoriController@kategoriAllJson'); //List Kategori
});


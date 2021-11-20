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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'CompaniesController@index')->name('admin.index');


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'CompaniesController@index')->name('admin.index');
    Auth::routes();
});


// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Route::get('companies', 'CompaniesController@index')->name('companies.index');
});

Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('qrcode/{id}', 'QRController@generateQrCode')->name('qrcode.index');
    Route::post('/download-qr-code/{type}', 'QRController@downloadQRCode')->name('qrcode.download');
});
// Route::get('/{any}', 'CompaniesController@index')->where('any', '.*');
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

<<<<<<< HEAD
Route::get('/', function () {
    return view('welcome');
});

Route::get('/{any}', 'CompaniesController@index')->where('any', '.*');

=======
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', 'CompaniesController@index')->where('any', '.*');

<<<<<<< HEAD
>>>>>>> parent of bd97740 (Created form)
=======
>>>>>>> parent of bd97740... Created form
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin_dashboard', 'Admin\DashboardController@index')->middleware('role:admin');
Route::get('/seller_dashboard', 'Seller\DashboardController@index')->middleware('role:seller');

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('companies', 'CompaniesController@index')->name('companies.index');
});

// Route::get('/admin', 'AdminController@index');
// Route::get('/superadmin', 'SuperAdminController@index');

Route::get('/{any}', 'CompaniesController@index')->where('any', '.*');
=======
// Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
//     Route::get('companies', 'CompaniesController@index')->name('companies.index');
// });
>>>>>>> parent of bd97740 (Created form)
=======
// Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
//     Route::get('companies', 'CompaniesController@index')->name('companies.index');
// });
>>>>>>> parent of bd97740 (Created form)
=======
// Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
//     Route::get('companies', 'CompaniesController@index')->name('companies.index');
// });
>>>>>>> parent of bd97740... Created form

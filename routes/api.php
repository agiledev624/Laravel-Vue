<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    Route::post('lockers/add', 'LockerController@add')->name('lockers.add');
    Route::post('lockers/new_assign', 'LockerController@new_assign')->name('lockers.new_assign');
    Route::post('lockers/open_lockers', 'LockerController@open_lockers')->name('lockers.open_lockers');
    Route::resource('lockers', 'LockerController');
    Route::resource('aparts', 'ApartController');
});

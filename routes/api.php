<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    Route::post('lockers/add', 'LockerController@add')->name('lockers.add');
    Route::resource('lockers', 'LockerController');
    Route::resource('aparts', 'ApartController');
    Route::post('settings/set_sms', 'SettingController@set_sms')->name('settings.set_sms');
    Route::get('settings/get_sms', 'SettingController@get_sms')->name('settings.get_sms');
    Route::resource('settings', 'SettingController');
});
Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::post('lockers/new_assign', 'LockerController@new_assign')->name('lockers.new_assign');
    Route::post('lockers/open_lockers', 'LockerController@open_lockers')->name('lockers.open_lockers');
});
<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    Route::post('lockers/add', 'LockerController@add')->name('lockers.add');
    Route::get('lockers/list/{id}', 'LockerController@list')->name('lockers.list');
    Route::get('lockers/get_status/{id}', 'LockerController@get_status')->name('lockers.get_status');
    Route::resource('lockers', 'LockerController');
    Route::get('aparts/list/{id}', 'ApartController@list')->name('aparts.list');
    Route::resource('aparts', 'ApartController');
    Route::post('settings/set_sms', 'SettingController@set_sms')->name('settings.set_sms');
    Route::get('settings/get_sms', 'SettingController@get_sms')->name('settings.get_sms');
    Route::get('settings/get_foyer', 'SettingController@get_foyer')->name('settings.get_foyer');
    Route::post('settings/set_foyer', 'SettingController@set_foyer')->name('settings.set_foyer');
    Route::resource('settings', 'SettingController');
    Route::get('couriers/list/{id}', 'CourierController@list')->name('couriers.list');
    Route::post('couriers/reset_password', 'CourierController@reset_password')->name('couriers.reset_password');
    Route::resource('couriers', 'CourierController');
});
Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.', 'middleware' => ['auth:api', 'role:admin']], function () {
    Route::resource('users', 'UserController');
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::get('lockers/check_courier/{id}', 'LockerController@check_courier')->name('lockers.check_courier');
    Route::get('lockers/check_owner/{id}', 'LockerController@check_owner')->name('lockers.check_owner');
    Route::post('lockers/new_assign', 'LockerController@new_assign')->name('lockers.new_assign');
    Route::post('lockers/access_foyer', 'LockerController@access_foyer')->name('lockers.access_foyer');
    Route::post('lockers/open_lockers', 'LockerController@open_lockers')->name('lockers.open_lockers');
    Route::post('lockers/open_locker', 'LockerController@open_locker')->name('lockers.open_locker');
    Route::post('lockers/notify_owner', 'LockerController@notify_owner')->name('lockers.notify_owner');
    Route::post('lockers/check_reminder', 'LockerController@check_reminder')->name('lockers.check_reminder');
});

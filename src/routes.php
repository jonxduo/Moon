<?php

Route::get('/admin/{module}/{id}/edit', 'App\Http\Controllers\MoonController@edit')->name('moon.edit');
Route::get('/admin/{module}/create', 'App\Http\Controllers\MoonController@create')->name('moon.create');
Route::get('/admin/{module}/{id}', 'App\Http\Controllers\MoonController@show')->name('moon.show');
Route::delete('/admin/{module}/{id}', 'App\Http\Controllers\MoonController@destroy')->name('moon.destroy');
Route::put('/admin/{module}', 'App\Http\Controllers\MoonController@update')->name('moon.update');
Route::post('/admin/{module}', 'App\Http\Controllers\MoonController@store')->name('moon.store');
Route::get('/admin/{module}', 'App\Http\Controllers\MoonController@index')->name('moon.index');

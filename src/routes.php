<?php

Route::resource('/admin/module', 'App\Http\Controllers\Moon\ModuleController')->middleware('web');
Route::resource('/admin/field', 'App\Http\Controllers\Moon\FieldController')->middleware('web');

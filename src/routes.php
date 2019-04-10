<?php

Route::resource('/admin/module', 'Jxd\Moon\Controllers\ModuleController')->middleware('web');
Route::resource('/admin/field', 'Jxd\Moon\Controllers\FieldController')->middleware('web');

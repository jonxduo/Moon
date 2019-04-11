<?php

Route::namespace('Jxd\Moon\Controllers')->group(function(){
    Route::resource('/admin/module', 'ModuleController')->middleware('web');
    Route::resource('/admin/field', 'FieldController')->middleware('web');
});

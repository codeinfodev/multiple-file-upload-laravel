<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('fileupload');
});

Route::view('/file-upload','fileupload')->name('fileupload');
Route::post('file-upload','UploadController@FileUpload');
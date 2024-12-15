<?php

use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [UploadFileController::class, 'upload'])
    ->name('upload');

Route::post('/upload', [UploadFileController::class, 'store'])
    ->name('upload');

Route::get('/store', [UploadFileController::class, 'add_data'])
    ->name('store');

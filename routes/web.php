<?php

use App\Http\Controllers\ChannelSettingsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoUploadController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function(){
    Route::get('upload/',[VideoUploadController::class,'index']);
    Route::post('video',[VideoController::class,'store']);
    Route::get('channel/{channel}/edit',[ChannelSettingsController::class,'edit']);
    Route::put('channel/{channel}/edit',[ChannelSettingsController::class,'update']);
});
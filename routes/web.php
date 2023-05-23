<?php

use App\Http\Controllers\ChannelSettingsController;
use App\Http\Controllers\EncodingWebhookController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoUploadController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/webhook/encoding', [EncodingWebhookController::class,'handle']);

Route::group(['middleware'=>['auth']],function(){
    Route::get('upload',[VideoUploadController::class,'index']);
    Route::post('upload',[VideoUploadController::class,'store']);

    Route::get('videos',[VideoController::class,'index']);
    Route::post('videos',[VideoController::class,'store']);
    Route::put('videos/{video}',[VideoController::class,'update']);

    Route::get('channel/{channel}/edit',[ChannelSettingsController::class,'edit']);
    Route::put('channel/{channel}/edit',[ChannelSettingsController::class,'update']);
});
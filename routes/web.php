<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json(
        [
            'project' => 'Chrome_Extension_Video_Uploader API',
            'name' => 'Chrome_Extension_Video_Uploader',
            'author' => 'Olorunda Abiodun',
            'email' => 'splendidabbey@gmail.com',
            'description' => 'This is an API for uploading videos to a server using a chrome extension',
            'version' => '1.0.0',
        ]);
});

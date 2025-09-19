<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return "Hello World dari laravel!";
});

//baru
Route::get('/nama', function () {
    return "Hello, nama saya Rifa Dwi Utami!";
});



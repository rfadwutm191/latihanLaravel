<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\RuanganController;
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

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);

Route::get('/ruangan', [RuanganController::class, 'index']);
Route::post('/ruangan', [RuanganController::class, 'store']);

Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::post('/matakuliah', [MatakuliahController::class, 'store']);
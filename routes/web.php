<?php

use Illuminate\Http\Request;
use App\Http\Controllers\batasOptimalController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\lupaPasswordController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\riwayatPencatatanController;
use App\Http\Controllers\ArduinoController;
use App\Models\pencatatan_suhu;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Route;
use setasign\Fpdi\PdfParser\Type\PdfStream;

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
    return view('login');
})->name('home')->middleware('guest');

Route::post('/login', [loginController::class, 'authenticate'])->name('login')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::resource('/profile', profileController::class)->middleware('auth');
Route::resource('/beranda', berandaController::class)->only(['index'])->middleware('auth');
Route::get('/riwayat_pencatatan', [riwayatPencatatanController::class, 'index'])->name('riwayat')->middleware('auth');
Route::resource('/batas_optimal', batasOptimalController::class)->middleware('auth');
Route::resource('/lupa_password', lupaPasswordController::class)->middleware('guest');
Route::put('/profile/update_username/{id}', [profileController::class, 'update_username'])->name('update_username')->middleware('auth');
Route::put('/profile/update_password/{id}', [profileController::class, 'update_password'])->name('update_password')->middleware('auth');
Route::put('/new_password', [lupaPasswordController::class, 'ubahPassword'])->name('password_baru')->middleware('guest');
Route::post('/setSelectedIkanId', [riwayatPencatatanController::class, 'setSelectedIkanId'])->name('setSelectedIkanId');
Route::get('/riwayat-pencatatan/filter', [RiwayatPencatatanController::class, 'filterByDate'])->name('filter_riwayat');
Route::get('/cetak_history', [RiwayatPencatatanController::class, 'cetak_history'])->name('cetak_history');

Route::get('/download_history_suhu_pdf', [riwayatPencatatanController::class, 'cetak_suhu'])->name('cetak_history_suhu_pdf');
Route::get('/download_history_ph_pdf', [riwayatPencatatanController::class, 'cetak_ph'])->name('cetak_history_ph_pdf');

// Route::post('/arduino/storeData/{ikanId}', 'ArduinoController@storeData');
Route::post('/arduino/storeData/{ikanId}', [ArduinoController::class, 'storeData']);
Route::get('/arduino/storeData/{ikanId}', [ArduinoController::class, 'storeData']);
Route::post('/arduino/store/', [ArduinoController::class, 'store']);
Route::get('/getDataOptimal/{id}', [batasOptimalController::class, 'getDataBatasOptimal'])->name('btsOptimal');
Route::put('/ubah_batas_suhu/{id}', [batasOptimalController::class, 'update_batas_suhu'])->name('update_batas_suhu');
Route::put('/ubah_batas_ph/{id}', [batasOptimalController::class, 'update_batas_ph'])->name('update_batas_ph');
Route::get('/beranda/{ikan_id}', [berandaController::class, 'index'])->name('beranda');
Route::get('/arduino/checkOptimalConditions/', [ArduinoController::class, 'checkOptimalConditions']);



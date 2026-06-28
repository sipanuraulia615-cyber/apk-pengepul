<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardPemilikController;
use App\Http\Controllers\DashboardPetugasController; // <--- Ditambahkan untuk Dashboard Petugas
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\TransaksiBeliController;
use App\Http\Controllers\TransaksiJualController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\SayurController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

// --- PILIH HAK AKSES & AUTH ---
Route::get('/', function () {
    return view('pilihakses');
})->name('pilihakses');

Route::get('/akses/{role}', function ($role) {
    session(['hak_akses' => $role]);
    return redirect()->route('login');
})->name('akses');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// =========================================================================================
// --- HAK AKSES: PETUGAS ---
// =========================================================================================

// Diubah agar memanggil DashboardPetugasController yang mengambil data dinamis dari database
Route::get('/dashboard', [\App\Http\Controllers\DashboardPetugasController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// --- DATA MASTER SAYURAN ---
Route::get('/datasayur', [SayurController::class, 'index'])->middleware(['auth', 'verified'])->name('datasayur');
Route::post('/datasayur', [SayurController::class, 'store'])->middleware(['auth'])->name('datasayur.store');
Route::patch('/datasayur/{id_sayur}', [SayurController::class, 'update'])->middleware(['auth'])->name('datasayur.update');
Route::delete('/datasayur/{id_sayur}', [SayurController::class, 'destroy'])->middleware(['auth'])->name('datasayur.destroy');

// --- DATA MASTER PETANI ---
Route::get('/datapetani', [PetaniController::class, 'index'])->middleware(['auth', 'verified'])->name('datapetani');
Route::post('/datapetani', [PetaniController::class, 'store'])->middleware(['auth'])->name('datapetani.store');
Route::patch('/datapetani/{id_petani}', [PetaniController::class, 'update'])->middleware(['auth'])->name('datapetani.update');
Route::delete('/datapetani/{id_petani}', [PetaniController::class, 'destroy'])->middleware(['auth'])->name('datapetani.destroy');

// --- TRANSAKSI BELI ---
Route::get('/transaksibeli', [TransaksiBeliController::class, 'index'])->middleware(['auth', 'verified'])->name('transaksibeli');
Route::post('/transaksibeli', [TransaksiBeliController::class, 'store'])->middleware(['auth'])->name('transaksibeli.store');
Route::patch('/transaksibeli/{id_beli}', [TransaksiBeliController::class, 'update'])->middleware(['auth'])->name('transaksibeli.update');
Route::delete('/transaksibeli/{id_beli}', [TransaksiBeliController::class, 'destroy'])->middleware(['auth'])->name('transaksibeli.destroy');

// --- TRANSAKSI JUAL ---
Route::get('/transaksijual', [TransaksiJualController::class, 'index'])->middleware(['auth', 'verified'])->name('transaksijual');
Route::post('/transaksijual', [TransaksiJualController::class, 'store'])->middleware(['auth'])->name('transaksijual.store');
Route::patch('/transaksijual/{id_jual}', [TransaksiJualController::class, 'update'])->middleware(['auth'])->name('transaksijual.update');
Route::delete('/transaksijual/{id_jual}', [TransaksiJualController::class, 'destroy'])->middleware(['auth'])->name('transaksijual.destroy');

// =========================================================================================
// --- HAK AKSES: PEMILIK ---
// =========================================================================================

Route::get('/pemilik', [DashboardPemilikController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboardpemilik');

// --- STOK SAYURAN ---
Route::get('/stoksayuran', [TransaksiBeliController::class, 'stokSayurPemilik'])->middleware(['auth'])->name('stoksayuran');
Route::patch('/stoksayuran/{id_sayur}', [TransaksiBeliController::class, 'updateStokManual'])->middleware(['auth'])->name('stoksayuran.update');

// --- LAPORAN BELI ---
Route::get('/laporan-beli', [TransaksiBeliController::class, 'laporanBeliPemilik'])->middleware(['auth', 'verified'])->name('laporan.beli');

// --- LAPORAN JUAL ---
Route::get('/laporanjual', [TransaksiJualController::class, 'laporanJualPemilik'])->middleware(['auth', 'verified'])->name('laporan.jual');

// --- ASISTEN CHATBOT ---
Route::get('/asistenchatbot', function () {
    return view('dashboardpemilik.asistenchatbot');
})->middleware(['auth', 'verified'])->name('asistenchatbot');

// --- CHATBOT PROSES ---
Route::post('/chatbot', [ChatbotController::class, 'proses'])->middleware(['auth'])->name('chatbot.proses');

// --- DATA MASTER PETUGAS ---
Route::get('/datapetugas', [PetugasController::class, 'index'])->middleware(['auth', 'verified'])->name('datapetugas');
Route::post('/datapetugas', [PetugasController::class, 'store'])->middleware(['auth'])->name('datapetugas.store');
Route::patch('/datapetugas/{id_petugas}', [PetugasController::class, 'update'])->middleware(['auth'])->name('datapetugas.update');
Route::delete('/datapetugas/{id_petugas}', [PetugasController::class, 'destroy'])->middleware(['auth'])->name('datapetugas.destroy');

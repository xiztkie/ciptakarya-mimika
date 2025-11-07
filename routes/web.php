<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterdataController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\UsersController;
use App\Models\DokumentasiModel;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    /* PROFILE */
    Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UsersController::class, 'updateprofile'])->name('updateprofile');
    Route::post('/profile/changepassword', [UsersController::class, 'changepassword'])->name('changepassword');
    Route::post('/profile/updateavatar', [UsersController::class, 'updateavatar'])->name('updateavatar');
    Route::middleware(['role:Admin'])->group(function () {
        /* SYNC DATA */
        Route::get('/sync-data', [SyncController::class, 'index'])->name('sync-data');
        Route::post('/sync-data/penyedia', [SyncController::class, 'syncpenyedia'])->name('syncpenyedia');
        Route::post('/sync-data/lokasi-penyedia', [SyncController::class, 'synclokasipenyedia'])->name('synclokasipenyedia');
        Route::post('/sync-data/paket-tender', [SyncController::class, 'synctender'])->name('synctender');
        Route::post('/sync-data/paket-nontender', [SyncController::class, 'syncnontender'])->name('syncnontender');
        Route::post('/sync-data/kontrak-tender', [SyncController::class, 'synckontraktender'])->name('synckontraktender');
        Route::post('/sync-data/kontrak-nontender', [SyncController::class, 'synckontraknontender'])->name('synckontraknontender');

        /* DATA USER */
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::post('/users/add', [UsersController::class, 'adduser'])->name('adduser');
        Route::post('/users/edit/{id}', [UsersController::class, 'edituser'])->name('edituser');
        Route::post('/users/delete/{id}', [UsersController::class, 'deleteuser'])->name('deleteuser');
        Route::post('/users/changepass/{id}', [UsersController::class, 'changepass'])->name('changepass');

        /* MASTER DATA */
        Route::get('/masterdata/datapaket', [MasterdataController::class, 'datapaket'])->name('datapaket');
        Route::post('/masterdata/datapaket/edit/{id}', [MasterdataController::class, 'editpaket'])->name('editpaket');
        Route::get('/masterdata/datapaket/detail/{id}', [MasterdataController::class, 'detailpaket'])->name('detailpaket');
        Route::post('/masterdata/datapaket/updatemaps/{id}', [MasterdataController::class, 'updatemaps'])->name('updatemaps');
        Route::post('/masterdata/datapaket/dokumentasi/add/{id}', [DokumentasiController::class, 'adddokumentasi'])->name('adddokumentasi');
        Route::post('/masterdata/datapaket/dokumentasi/delete/{id}', [DokumentasiController::class, 'deletedokumentasi'])->name('deletedokumentasi');
        Route::post('/masterdata/datapaket/detailedit/{id}', [MasterdataController::class, 'editpaketdetail'])->name('editpaketdetail');

        /* BIDANG */
        Route::get('/masterdata/bidang', [MasterdataController::class, 'bidang'])->name('bidang');
        Route::post('/masterdata/bidang/add', [MasterdataController::class, 'addbidang'])->name('addbidang');
        Route::post('/masterdata/bidang/edit/{id}', [MasterdataController::class, 'editbidang'])->name('editbidang');
        Route::post('/masterdata/bidang/delete/{id}', [MasterdataController::class, 'deletebidang'])->name('deletebidang');

        /* PENYEDIA */
        Route::get('/masterdata/penyedia', [MasterdataController::class, 'datapenyedia'])->name('datapenyedia');
        Route::post('/masterdata/penyedia/edit/{id}', [MasterdataController::class, 'editpenyedia'])->name('editpenyedia');
        Route::post('/masterdata/penyedia/sync', [SyncController::class, 'syncdatapenyedia'])->name('syncdatapenyedia');
        Route::post('/masterdata/penyedia/sync/sikap', [SyncController::class, 'syncdatapenyediasikap'])->name('syncdatapenyediasikap');
        Route::post('/sync-data/penyedia-sikap', [SyncController::class, 'syncpenyediasikap'])->name('syncpenyediasikap');

        /* LAPORAN */
        Route::get('/laporan/laporanpaket', [LaporanController::class, 'laporanpaket'])->name('laporanpaket');
        Route::get('laporan/export/laporanpaketpdf', [LaporanController::class, 'exportpdflaporanpaket'])->name('exportpdflaporanpaket');
        Route::get('laporan/export/laporanpaketexcel', [LaporanController::class, 'exportexcelaporanpaket'])->name('exportexcelaporanpaket');
        Route::get('/laporan/laporanperpenyedia', [LaporanController::class, 'laporanperpenyedia'])->name('laporanperpenyedia');
        Route::get('laporan/export/laporanperpenyediapdf', [LaporanController::class, 'exportpdflaporanperpenyedia'])->name('exportpdflaporanperpenyedia');
        Route::get('laporan/export/laporanperpenyediaexcel', [LaporanController::class, 'exportexcelaporanperpenyedia'])->name('exportexcelaporanperpenyedia');
    });
    Route::middleware(['role:User'])->group(function () {});
});

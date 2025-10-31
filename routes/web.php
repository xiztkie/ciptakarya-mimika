<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
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
    });
    Route::middleware(['role:User'])->group(function () {});
});

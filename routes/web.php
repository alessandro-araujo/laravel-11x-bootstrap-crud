<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Rotas de login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');
Route::get('/create-user-login', [LoginController::class, 'create'])->name('login.create');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::post('/create', [LoginController::class, 'store'])->name('login.store');

Route::get('/test', [UserController::class, 'test'])->name('test');

Route::group(['middleware' => 'auth'], function(){
    // Rotas CRUD
    Route::post('/store-user', [UserController::class, 'store'])->name('user-store');
    Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user-update');
    Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    
    // Rotas Viwe
    Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
    Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
}); 

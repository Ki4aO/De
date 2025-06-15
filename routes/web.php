<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\ViewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ViewsController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth']);

Route::get('/login', [ViewsController::class, 'login'])
    ->name('login')
    ->middleware(['guest']);
Route::post('/login', [ActionsController::class, 'login'])
    ->middleware('guest');

Route::get('/login/change-password', [ViewsController::class, 'changePassword'])
    ->name('login.change-password')
    ->middleware(['auth']);
Route::post('/login/change-password', [ActionsController::class, 'changePassword'])
    ->middleware('auth');

Route::get('/user/{user?}', [ViewsController::class, 'editUser'])
    ->name('user')
    ->middleware(['auth']);
Route::delete('/user/{user}', [ActionsController::class, 'deleteUser'])
    ->name('user.delete')
    ->middleware(['auth']);
Route::patch('/user/{user}', [ActionsController::class, 'unlockUser'])
    ->name('user.unlock')
    ->middleware(['auth']);
Route::post('/user', [ActionsController::class, 'createUser'])
    ->name('user.save')
    ->middleware(['auth']);
Route::put('/user/{user}', [ActionsController::class, 'editUser'])
    ->name('user.update')
    ->middleware(['auth']);

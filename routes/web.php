<?php

use App\Http\Controllers\AlgorithmController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\TreeController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ])->group(function () {

    Route::get('/', [TreeController::class, 'index'])
    ->name('dashboard')->middleware(['auth']);
    
    Route::get('/dashboard', [TreeController::class, 'index'])
    ->name('dashboard');

    Route::get('/secure', [TreeController::class, 'secure'])
    ->name('secure');

    Route::get('/data', [TreeController::class, 'data'])
    ->name('data');

    Route::post('/trees/store', [TreeController::class, 'store'])
    ->name('trees.store');
    
    Route::get('/trees/{id}/edit', [TreeController::class, 'edit'])->name('trees.edit');
    
    Route::delete('/trees/{id}/delete', [TreeController::class, 'delete'])->name('trees.delete');
    
    Route::put('/trees/{id}', [TreeController::class, 'update'])->name('trees.update');

    Route::get('/detail/{id}', [TreeController::class, 'detail'])->name('trees.show');

    Route::post('/member/store', [FamilyController::class, 'store'])->name('family.store');

    Route::get('/family_members/{id}/edit', [FamilyController::class, 'edit'])->name('family_members.edit');

    Route::put('/family_members/{id}/update', [FamilyController::class, 'update'])->name('family_members.update');

    Route::delete('/family_members/{id}', [FamilyController::class, 'destroy'])->name('family_members.destroy');

    Route::get('/family-tree/{id}', [FamilyController::class, 'showFamilyTree']);

    Route::fallback([TreeController::class, 'notFound']);

    Route::post('/family/compare', [AlgorithmController::class, 'compare'])->name('family.compare');

});

Route::get('/', [GuestController::class, 'index'])->name('dashboard')->middleware('guest');

Route::get('/guest/detail/{id}', [GuestController::class, 'detail'])->name('guest.show')->middleware('guest');



<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TrelloControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tasks/move', [TasksController::class, 'move'])->name('tasks.move');
Route::get('/kanban', [TrelloControllers::class, 'showBoard'])->middleware('auth');

Route::get('/fonctionnalités', function () {
    return view('fonctionnalités');
})->name('fonctionnalités');

Route::get('/solutions', function () {
    return view('solutions');
})->name('solutions');

Route::get('/Ressources', function () {
    return view('Ressources');
})->name('Ressources');

Route::get('/Offres', function () {
    return view('Offres');
})->name('Offres');

Route::get('/Pricing', function () {
    return view('Pricing');
})->name('Pricing');


require __DIR__.'/auth.php';

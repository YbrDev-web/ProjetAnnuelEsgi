<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\CardController;

Route::middleware('auth')->put('/password', [PasswordController::class, 'update'])->name('password.update');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', function(){
    return('bonjour');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/boards', [BoardController::class, 'store'])->name('boards.store');
Route::post('/boards/{board}/add-member', [BoardController::class, 'addMember'])->name('boards.addMember');

Route::get('/boards/{board}/members', [BoardController::class, 'members'])->name('boards.members');
Route::post('/boards/{board}/members', [BoardController::class, 'invite'])->name('boards.members.invite');
Route::patch('/boards/{board}/members/{user}', [BoardController::class, 'updateRole'])->name('boards.members.update');
Route::delete('/boards/{board}/members/{user}', [BoardController::class, 'removeMember'])->name('boards.members.remove');
Route::delete('/boards/{board}/remove-member/{user}', [BoardController::class, 'removeMember'])->name('boards.removeMember');


Route::get('/boards/my', [BoardController::class, 'myBoards'])->name('boards.my');
Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('/help', [HelpController::class, 'index'])->name('help.index');
Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::get('/boards/{board}/project', [BoardController::class, 'project'])->name('boards.project');
Route::post('/boards/{board}/lists', [ListController::class, 'store'])->name('lists.store');
Route::post('/lists/{list}/cards', [CardController::class, 'store'])->name('cards.store');
Route::get('/boards/{board}', [BoardController::class, 'show'])->name('boards.show');
Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
Route::post('/cards/{card}/move', [\App\Http\Controllers\CardController::class, 'move'])->name('cards.move');
Route::get('/boards/{board}/cards', [CardController::class, 'index'])->name('cards.index');
Route::post('/boards/{board}/invite', [BoardController::class, 'invite'])->name('boards.members.invite');
Route::delete('/boards/{board}', [BoardController::class, 'destroy'])->name('boards.destroy');

Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
Route::patch('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
Route::get('/boards/{board}/tasks', [\App\Http\Controllers\CardController::class, 'list'])->name('cards.list');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tasks/move', [TasksController::class, 'move'])->name('tasks.move');


require __DIR__.'/auth.php';

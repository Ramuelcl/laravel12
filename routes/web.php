<?php

use App\Http\Controllers\formController;
//
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//FORMULARIO
Route::group(['prefix' => 'formulario', 'as' => 'formulario.', 'controller' => FormController::class], function () {
    Route::get('/', 'create')->name('create'); // nombre completo: formulario.create
    Route::post('/', 'store')->name('store');  // nombre completo: formulario.store
});
// Route::get("formulario", [FormController::class, "create"])->name("formulario.create");
// Route::post("formulario", [FormController::class, "store"])->name("formulario.store");

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('posts', 'posts.posts')
    ->middleware(['auth', 'verified'])
    ->name('posts');

Route::view('main', 'main')
    ->middleware(['auth', 'verified'])
    ->name('main');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';

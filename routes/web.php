<?php

use App\Livewire\Home\About;
use App\Livewire\Home\Contact;
use App\Livewire\Home\Index as Home;
use App\Livewire\Home\Services;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Home::class)->name('home.index');
Route::get('/nosotros', About::class)->name('home.about');
Route::get('/productos', Services::class)->name('home.services');
Route::get('/contactenos', Contact::class)->name('home.contact');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

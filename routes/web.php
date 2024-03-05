<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('auth/login');
});

Route::middleware(['guest'])->group(function () {
    Route::view('auth/login', 'auth.login')->name('login');
    Route::view('auth/register', 'auth.register')->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::view('expenses', 'expenses.index')->name('expenses.index');
    Route::view('stats', 'expenses.stats')->name('expenses.stats');
});

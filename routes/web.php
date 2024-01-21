<?php

use App\Livewire\Group\CreateGroup;
use App\Livewire\Group\IndexGroup;
use App\Livewire\Register;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\Person\CreatePerson;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return Auth::check() ? redirect('/home') : redirect('/login');
});

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/home', Home::class)->name('home');
    Route::get('/groups/create', CreateGroup::class)->name('groups.create');
    Route::get('/groups/index', IndexGroup::class)->name('groups.index');
    Route::get('/people/create', CreatePerson::class)->name('people.create');
});


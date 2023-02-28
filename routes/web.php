<?php

use App\Http\Livewire\Admin\DodajLekcijuComponent;
use App\Http\Livewire\Admin\DodajNovogUcenikaComponent;
use App\Http\Livewire\Admin\DodajOblastComponent;
use App\Http\Livewire\Admin\DodajRazredComponent;
use App\Http\Livewire\Admin\KalendarComponent;
use App\Http\Livewire\Admin\RazrediComponent;
use App\Http\Livewire\Admin\UceniciComponent;
use App\Http\Livewire\Admin\UcenikComponent;
use App\Http\Livewire\Admin\UrediHomeComponent;
use App\Http\Livewire\Admin\UrediLekcijuComponent;
use App\Http\Livewire\Admin\UrediSekcijuComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\LekcijaComponent;
use App\Http\Livewire\LekcijeComponent;
use App\Http\Livewire\ObjaveComponent;
use App\Http\Livewire\SekcijeComponent;
use App\Http\Livewire\User\KalendarRazredComponent;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class)->name('home');
Route::get('/sekcije', SekcijeComponent::class)->name('sekcije');
Route::get('/lekcije/{sekcija_id}', LekcijeComponent::class)->name('lekcije');
Route::get('/lekcija/{lekcija_id}', LekcijaComponent::class)->name('lekcija');
Route::get('/objave', ObjaveComponent::class)->name('objave');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

//Za ucenike
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/kalendar/{razred_name}', KalendarRazredComponent::class)->name('kalendar.razred');
});

//Za profesora
Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/ucenici', UceniciComponent::class)->name('ucenici');
    Route::get('/registracija', DodajNovogUcenikaComponent::class)->name('registracija');
    Route::get('/razredi', RazrediComponent::class)->name('razredi');
    Route::get('/razred/dodaj', DodajRazredComponent::class)->name('razred.dodaj');
    Route::get('/ucenik/{ucenik_id}', UcenikComponent::class)->name('ucenik');
    Route::get('/kalendar', KalendarComponent::class)->name('kalendar');
    Route::get('/sekcija/dodaj', DodajOblastComponent::class)->name('oblast.dodaj');
    Route::get('/lekcija/dodaj/{sekcija_id}', DodajLekcijuComponent::class)->name('lekcija.dodaj');
    Route::get('/sekcija/uredi/{sekcija_id}', UrediSekcijuComponent::class)->name('sekcija.uredi');
    Route::get('/lekcija/uredi/{lekcija_id}', UrediLekcijuComponent::class)->name('lekcija.uredi');
    Route::get('/home/uredi/{home_id}', UrediHomeComponent::class)->name('home.uredi');
});
<?php

use App\Models\Kid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    // if(Auth::user() == null) {
    //     return redirect()->to('/login');
    // } else {
    //     return redirect()->to('/dashboard');
    // }
    return view('welcome');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('kids', 'kids.index')
    ->middleware(['auth', 'verified'])
    ->name('kids.index');

Route::view('kids/create', 'kids.create')
    ->middleware(['auth', 'verified'])
    ->name('kids.create');

Route::get('/kids/{id}', function($id) {
    return view('kids.edit')
        ->with('kid', Kid::findOrFail($id));
})
    ->middleware(['auth', 'verified'])
    ->name('kids.edit');

//-------------------------
//TRIPS
//-------------------------

Route::view('trips/create', 'trips.create')
    ->middleware(['auth', 'verified'])
    ->name('trips.create');

Route::get('/trip/{id}', function($id) {
    return view('trip.edit')
        ->with('trip', Kid::findOrFail($id));
})
    ->middleware(['auth', 'verified'])
    ->name('trip.edit');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

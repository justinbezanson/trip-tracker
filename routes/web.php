<?php

use App\Models\Kid;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    if(Auth::user() == null) {
        return redirect()->to('/login');
    } else {
        return redirect()->to('/dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function() {
    /** @var User $user */
    $user = Auth::user();
    $trips = Trip::with('kids')->where('user_id', $user->id)->get();
    $kids = Kid::with([
        'trips' => function ($q) {
        $q->orderBy('when', 'asc');
    }])
        ->orderBy('name', 'asc')
        ->get();

    return view('dashboard', [ 'trips' => $trips, 'kids' => $kids ]);
})
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

Route::get('/trips/{id}', function($id) {
    return view('trips.edit')
        ->with('trip', Trip::findOrFail($id));
})
    ->middleware(['auth', 'verified'])
    ->name('trips.edit');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::resource('people', PersonController::class);
Route::get('/people/{id}/edit', [PersonController::class, 'edit'])->name('people.edit');
Route::put('/people/{id}', [PersonController::class, 'update'])->name('people.update');


Route::get('/', function () {
    return view('welcome');
});



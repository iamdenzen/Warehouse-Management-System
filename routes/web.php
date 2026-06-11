<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Station\Workstation;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/station/{station}', Workstation::class)
    ->name('station.workstation');
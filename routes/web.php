<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('filament.organization.auth.login'));
})->name('login');

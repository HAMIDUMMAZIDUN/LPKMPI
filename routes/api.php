<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/verify-certificate', [ApiController::class, 'verifyCertificate'])->name('api.verify');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

Route::get('/api/cities/{province_id}', [LocationController::class, 'getCities']);
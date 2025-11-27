<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MultiImageUploadController;


Route::post('/upload-multiple-images', [MultiImageUploadController::class, 'store']);
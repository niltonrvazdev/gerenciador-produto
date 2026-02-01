<?php

use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    // Usamos .names('api.products') para não chocar com a web
    Route::apiResource('products', ProductApiController::class)->names('api.products');
});

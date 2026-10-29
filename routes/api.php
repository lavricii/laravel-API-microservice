<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;

Route::get('/quote', [QuoteController::class, 'index']);
Route::get('/quote/search', [QuoteController::class, 'search']);
Route::post('/quote', [QuoteController::class, 'store']);

Route::get('/quote/{identifier}', [QuoteController::class, 'showByIdentifier']);
Route::put('/quote/{identifier}', [QuoteController::class, 'updateByIdentifier']);
Route::delete('/quote/{id}', [QuoteController::class, 'delete']);

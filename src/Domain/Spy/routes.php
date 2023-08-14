<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\Spy\SpyCollectionController;
use App\Http\Controllers\Api\Spy\SpyCreateController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'spy'], static function () {
        Route::post('/', SpyCreateController::class)->name('spy.create');

        Route::middleware(['throttle:10,1'])
            ->get('/random', [SpyCollectionController::class, 'random'])
            ->name('spy.find');

        Route::get('/', [SpyCollectionController::class, 'all'])->name('spy.all');
    });
});

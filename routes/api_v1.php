<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoryController;
/* setup api category */
Route::group([
    //'middleware' => 'auth:api',
    'prefix' => 'v1'], function ($router) {
    /* category */
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');

});
?>

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

    /* product */
    Route::get('products', [\App\Http\Controllers\Api\V1\ProductController::class, 'filter'])->name('products.filter');
    Route::get('products/{id}', [\App\Http\Controllers\Api\V1\ProductController::class, 'show'])->name('products.show');

    // cart
    Route::resource('carts', \App\Http\Controllers\Api\V1\CartController::class);

});
?>

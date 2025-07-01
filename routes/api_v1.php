<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoryController;
/* setup api category */
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'v1'
], function ($router) {
    Route::get('categories', [CategoryController::class, 'index']);
});
?>

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Psr7\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});


Route::post('/upload/avatar',function(Request $request){

    if($request->hasFile('image')){
       //return Response()->json(array("success" => true));
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $exection = $file->getClientOriginalExtension();
        $file->move(public_path().'/uploads/', $name);
        return Response()->json(array("success" => true,
        'path' => public_path().'/uploads/'.$name));
    }
});

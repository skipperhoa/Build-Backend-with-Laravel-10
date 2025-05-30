<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',function(Request $request){

    // cách 1:
    if($request->has('status')){
        $request->merge(['status' => 1]);
    }

    // cách 2:
    $request->mergeIfMissing(['status' => 1]);

    return Response()->json([
        'status' => $request->status
    ]);
});

require __DIR__.'/admin.php';

require __DIR__.'/auth.php';



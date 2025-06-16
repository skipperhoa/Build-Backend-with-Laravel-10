<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// cách sử dụng saveMany() để lưu nhiều bản ghi cùng lúc
Route::get('/test/save-many', function () {

    $users = [];
    for ($i = 0; $i < 3; $i++) {
        $users[] = new \App\Models\User([
            'name' => 'User ' . $i,
            'email' => 'user' . $i . '@example.com',
            'password' => bcrypt('password'),
        ]);
    }
    \App\Models\User::query()->saveMany($users);

    return response()->json(['message' => 'Users created successfully']);
});

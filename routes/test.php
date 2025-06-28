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

    // lấy tất cả permissions
    $permissions = \App\Models\Permission::get();

    // dd($permissions->toArray());

    $user =\App\Models\User::where('email', 'nguyen.thanh.hoa.ctec@gmail.com')->first();

    // dùng saveMany() khi lưu nhiều bản ghi cùng lúc
    $user->permissions()->saveMany($permissions);


    // Xoá sạch tất cả permission của user
   /*   $permissionArrayId =$permissions->pluck('id')->toArray();
     $user->permissions()->detach();
     $user->permissions()->sync($permissionArrayId); */

   /*  $user_permissions = $user->permissions;

    dd($user_permissions->toArray()); */

    return response()->json(['message' => 'Users created successfully']);
});

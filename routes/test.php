<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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


Route::get('/test/validate', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'color' => 'required|in:red,green,blue',
        'variant' => 'required|in:small,medium,big',
        'size' => 'required|in:small,medium,big',
        'brand.*' => 'in:apple,oppo,realme',
    ]);
   if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
    }

    return response()->json(['message' => 'Users created successfully']);
});



Route::get('/test/raw-value',function(Request $request){

    $first = \App\Models\User::orderBy('created_at', 'asc')->rawValue('YEAR(`created_at`) as first_year');

    $last   = \App\Models\User::where('email', 'nguyen.thanh.hoa.ctec@gmail.com')->rawValue('YEAR(`created_at`) as last_year');

    $fullname = \App\Models\User::where('email', 'nguyen.thanh.hoa.ctec@gmail.com')
        ->rawValue('CONCAT(`name`," ", `id`) as fullname');

    $totalPrice = \App\Models\Product::where('category_id', 1)->rawValue('SUM(`price`) as total_price');

    $statRow = \App\Models\Product::where('category_id', 1)
    ->selectRaw('SUM(price) as total_price, AVG(price) as avg_price, MIN(price) as min_price, MAX(price) as max_price')
    ->first();

    $category = \App\Models\Category::withSum('products as total_price', 'price')->find(1);

    return Response()->json([
        'fullname' => $fullname,
        'first_year' => $first,
        'last_year' => $last,
        'total_price' => $totalPrice,
        'category' => $category,
        'statRow' => $statRow
    ]);

});



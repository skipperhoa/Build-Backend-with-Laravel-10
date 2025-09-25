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

/*
inRandomOrder() được sử dụng để lấy các bản ghi theo thứ t ự ngẫu nhiên.
*/
Route::get('/test/is-random-order',function(){

    $products = \App\Models\Product::inRandomOrder()->limit(3)->get();

    return response()->json([
        'status' => true,
        'data' => $products
    ]);
});

use Illuminate\Support\Facades\DB;
Route::get('/test/query-raw-in-laravel',function(Request $request){

    $search = $request->txt_search;
    // check name or lastname or email
    $users = \App\Models\User::query()
    ->where(function($subQuery) use ($search){
        $subQuery->where(DB::raw('CONCAT(`name`, " ", `email`)'), 'LIKE', "%{$search}%");
    })->get();

    return response()->json([
        'status' => true,
        'data' => $users
    ]);
});



Route::get('/test/where-value-between', function () {

    $start = '2025-06-27 04:04:28';
    $end = '2025-07-03 02:33:31';

    // Lấy tất cả người dùng có ngày tạo trong khoảng từ $start đến $end
    $products1 = \App\Models\Product::whereBetween('created_at', [$start, $end])->get();

    $products2 = DB::table('products')
        ->where('created_at', '>=', $start)
        ->where('created_at', '<=', $end)
        ->get();

    // Lấy tất cả người dùng có ngày tạo trong khoảng từ $start đến $end

    //$products3 = \App\Models\Product::whereValueBetween('created_at', $start, $end)->get();

    return response()->json([
        'status' => true,
        'products1' => $products1,
        'products2' => $products2,
       // 'products3' => $products3
    ]);
});

use Illuminate\Validation\Rules\Password;
Route::get('/test/form-request-validation', function () {
    $validator = Validator::make(request()->all(), [
        'name' => [
            'required'
        ],
        'email' =>[
            'required',
            'email'
        ],
        'password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->letters()
                ->symbols()
                ->mixedCase()
                ->uncompromised(), // comment hoặc xóa dòng này nếu không muốn kiểm tra mật khẩu bị lộ
        ],
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    return response()->json(['message' => 'Form request validation passed successfully']);

});

// create a password auto
use Illuminate\Support\Str;
Route::get('/test/create-a-password-auto',function(){
    $password = Str::password(
        16,  //length default: 32
        true, // letters default: true
        true, // numbers default: true
        true, // symbols default: true
        false // spaces
    );
    return Response()->json([
        'password' => $password
    ]);
});

// su dung transform method
Route::get('/test/transform-method-in-laravel',function(){

    // ví dụ tạo một mảng cart
    $list_carts = collect([
        ['id' => 1, 'name' => 'Product 1', 'price' => 100],
        ['id' => 2, 'name' => 'Product 2', 'price' => 200],
        ['id' => 3, 'name' => 'Product 3', 'price' => 300],
    ]);

    $list_carts->transform(function(array $cart){
        $cart['total_price'] = $cart['price'] * 2;
        return $cart;
    });

    $data = $list_carts->all();

    return Response()->json([
        'data' => $data
    ]);

});

// import multiple class models
use App\Models\{User, Product, Category};
use GuzzleHttp\Psr7\Response;

Route::get('/test/import-multiple-class-models', function () {

    $users = User::all();
    $products = Product::all();
    $categories = Category::all();

    return response()->json([
        'users' => $users,
        'products' => $products,
        'categories' => $categories
    ]);

});

// test benchmark get thoi gian thuc thi du lieu
use Illuminate\Support\Benchmark;

Route::get('/test/benchmark', function () {

    $ms = Benchmark::measure(fn() => Product::find(1));

    $ms_all_products = Benchmark::measure(fn() => Product::all());

    [$users,$time] = Benchmark::value(fn()=>User::latest()->take(10)->get());

    return Response()->json([
        'status' => true,
        'execution_time' => $ms . ' seconds',
        'ms_all_products' => $ms_all_products . ' seconds',
        'users' => $users,
        'execution_time_users' => $time . ' seconds'
    ]);
});


// test exclude_if
Route::get('/test/exclude_if',function(Request $request){

    $data = $request->validate([
        'is_approved' =>'required|boolean',
       // 'rejection_reason' => 'exclude_if:is_approved,true|required|string',
        // hoac
        'rejection_reason' => 'exclude_unless:is_approved,false|required|string',
    ]);

    return Response()->json([
        'data' => $data
    ]);
});

// test whereBelongsTo
Route::get('/test/where-belongs-to', function () {

    $category = Category::find(1);
    $user = User::find(18);
   /*  $products_old = Product::where('category_id', $category->id)
                ->where('user_id', $user->id)->first();
    $check_old = false;
    if($products_old->user_id==$user->id) $check_old = true;
    return response()->json([
        'status' => true,
        'check_old' => $check_old,
        'products_old' => $products_old
    ]); */

    $products_new = Product::whereBelongsTo($category)->whereBelongsTo($user)->first();
    $check_new = $products_new->user()->is($user);
    return response()->json([
        'status' => true,
        'check_new' => $check_new,
        'products_new' => $products_new
    ]);



});

// test permission and role in laravel
Route::get('/test/permission-role-by-user', function () {
    $user = User::find(1);
    $permissions = $user->permissions->pluck('name');
    $roles = $user->roles;
    $roles_permissions = $roles->map(function($role){
        return $role->permissions->pluck('name');
    });

   /*  if($user->hasAnyPermission(['admin.users.index', 'admin.users.create'])) {
        $users = User::all();
    } else {
        $users = [];
    } */

    $users = $user->can('admin.users.index') ? User::all() : [];

    return response()->json([
        'status' => true,
        'user_id' => $user->id,
        'permissions' => $permissions,
        'roles' => $roles,
        'roles_permissions' => $roles_permissions,
        'users' => $users
    ]);


});


use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
Route::get('/test/http-pool-multiple-request', function () {

    $responses = Http::pool(fn (Pool $pool)=>[
        $pool->as('categories')->timeout(5)->get('https://dummyjson.com/products/category-list'),
        $pool->as('products')->timeout(5)->get('https://dummyjson.com/products'),
        $pool->as('categories_list')->timeout(5)->get('http://127.0.0.1:8000/api/v1/categories')
    ]);

    $data = [
            'categories' => $responses['categories']->json(),
            'products' => $responses['products']->json(),
            'categories_list' => $responses['categories_list']->json()
        ];

    return response()->json([
        'status' => true,
        'data' => $data
    ]);

    /*
    $responses = Http::pool(fn (Pool $pool) => [
        $pool->as('categories')->timeout(5)->get('http://127.0.0.1:8000/api/v1/categories'),
        $pool->as('products')->timeout(5)->get('http://127.0.0.1:8000/api/v1/products')
    ]);

    // Check if responses are successful before calling json()
    $data = [];

    // Handle categories response
    if ($responses['categories']->successful()) {
        $data = [...$responses['categories']->json()];
    } else {
        $data['categories_error'] = 'Failed to fetch categories: ' . $responses['categories']->status();
    }

    // Handle products response
    if ($responses['products']->successful()) {
        $data['products'] = $responses['products']->json();
    } else {
        $data['products_error'] = 'Failed to fetch products: ' . $responses['products']->status();
    }

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
    */

});

/*
use App\Services\CategoryService;
use App\Services\ProductService;

Route::get('/test/service-calls', function () {

    try {
        $categoryService = app(CategoryService::class);
        $productService = app(ProductService::class);

        // Parallel execution using Laravel's parallel processing
        $results = collect([
            'categories' => fn() => $categoryService->getAll(),
            'products' => fn() => $productService->getAll(),
        ])->parallel();

        $data = [
            ...$results['categories'],
            'products' => $results['products']
        ];

        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});
*/

Route::get('/test/multiple-request-using-http-pool',function(){
    // call api prouduct, categories,...

    $responses = Http::pool(fn (Pool $pool) => [
        $pool->as('categories')->timeout(5)->get('http://127.0.0.1:8000/api/v1/categories'),
        $pool->as('products')->timeout(5)->get('http://127.0.0.1:8000/api/v1/products'),
        $pool->as('products_category')->timeout(5)->get('https://dummyjson.com/products/category-list')
    ]);

    $data = [
        'categories' => $responses['categories']->json(),
        'products' => $responses['products']->json(),
        'products_category' => $responses['products_category']->json()
    ];

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
});

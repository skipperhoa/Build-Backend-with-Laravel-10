<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function filter(Request $request)
    {
        /*
             cách 1: lấy tất cả column trong table "products"
             $allowedColumns = DB::connection()->getSchemaBuilder()->getColumnListing('products');

             cách 2 : lấy tất cả column trong table "products"
             $allowedColumns2 = Schema::getColumnListing('products');
        */
        /* cách 3: gắn trực tiếp các column được phép */
        $allowedColumns2 = [
            'id',
            'title',
            'description',
            'slug',
            'price',
            'category_id',
            'created_at',
            'updated_at'
        ];

        $validator = Validator::make($request->all(), [
            'column' => 'nullable|string|in:' . implode(',', $allowedColumns2),
            'sort'   => 'nullable|in:asc,desc',
            'limit'  => 'nullable|integer|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $column = $request->column ?? 'id';
        $sort   = $request->sort ?? 'desc';
        $limit  = $request->limit ?? 10;
        //lấy mối quan hệ giữa product và category
        $products = Product::with('category')
            ->orderBy($column, $sort) //sort
            ->paginate($limit); // phân trang

        return response()->json([
            "status" => true,
            "message" => "Products retrieved successfully",
            "products"   => $products
        ]);
    }
    /*
    Lấy thông tin product , theo id được request lên
    */
    public function show($id) {

        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // lấy các sản phẩm liên quan, và bỏ qua sản phẩm id hiện tại
        $products_more = Product::whereBelongsTo($product->category)->where('id', '!=', $id)->limit(5)->get();

        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully',
            'product' => $product,
            'products_more' => $products_more,
        ]);

    }
}


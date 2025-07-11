<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::with('children')->where('category_id', null)->get();
        return response()->json([
            "status" => true,
            "data" => $categories
        ]);
    }

    /*
    http://localhost:8000/api/v1/categories/search?filter=honda&sort=created_at:desc&page=2&pageSize=20
    */
    public function search(Request $request){

            $filter   = $request->input('filter');
            $sort     = $request->input('sort');
            $page     = (int) $request->input('page', 1);
            $pageSize = (int) $request->input('pageSize', 20);

            $query = Category::where('title',$filter)->first();

            if(!$query) return Response()->json(["status" => false, "message" => "Không tìm thấy danh mục"]);
            $categoriesIds = $query->getAllChildrenIds($query);

            //check sort
            $column_sort = explode(':', $sort); //created_at:desc
            $column = $column_sort[0];
            if(!Schema::hasColumn('products', $column)) $column = 'id';
            $direction = strtolower($column_sort[1] ?? 'desc');
            if (!in_array($direction, ['desc', 'asc'])) {
                $direction = 'desc';
            }
            //end sort

            $products = Product::whereIn('category_id', $categoriesIds)
                        ->orderBy($column, $direction)
                        ->paginate($pageSize, ['*'], 'page', $page);

            return response()->json([
                "status" => true,
                "categoriesIds" => $categoriesIds,
                "products" => $products,
                "direction"=>$direction,
                "column"=>$column
            ]);


        }

    }


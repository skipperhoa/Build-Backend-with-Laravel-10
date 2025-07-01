<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
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

}

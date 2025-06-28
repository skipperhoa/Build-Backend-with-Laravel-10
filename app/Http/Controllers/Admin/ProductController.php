<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // lấy tất cả categories
        $searchProduct = $request->search;


        $products = Product::whereAny(
            [
                'title',
                'slug'
            ],
            'LIKE',
            "%{$searchProduct}%"
        )->orderBy('id', 'desc')->paginate(10);


        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // gọi lấy danh sách categories parent
        $categories = Category::where('category_id', null)->get();

        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $validated = $request->validated();

        if(!$validated) {
            return redirect()->back()->withErrors($request->errors())->withInput();
        }
         // kiểm tra tồn tại "file" hay không, nếu có, ta sẽ lưu hình ảnh
        $image = null;
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $exection = $file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/', $name);
            $urlImage = URL::to('/').'/uploads/'.$name;
            $image = $urlImage;
        }
        $request->mergeIfMissing([
            'image' => $image,
            'user_id'=>Auth::user()->id
        ]);

        $product = Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success','Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

          // gọi lấy danh sách categories parent
        if(!$product) return abort(404);
        $categories = Category::where('category_id', null)->get();
        return view('admin.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
         $validated = $request->validated();

        if(!$validated) {
            return redirect()->back()->withErrors($request->errors())->withInput();
        }

        // check kiểm tra tấm hình
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $exection = $file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/', $name);
            $image = URL::to('/').'/uploads/'.$name;
            $product->image = $image;

        }

        $request->mergeIfMissing([
            'image' => $product->image,
            'user_id'=> Auth::user()->id
        ]);
        // gán mảng data tới product
        $product->fill($request->all());

        $product->save();

        return redirect()->route('admin.products.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product) {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success','Product deleted successfully');
        }
        return redirect()->route('admin.products.index')->with('error','Product not found');

    }
}

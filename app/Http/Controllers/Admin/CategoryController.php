<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Http\Request;
use App\Models\Category; //  thêm sử dụng model Category
use App\Models\User;
use Illuminate\Support\Facades\URL;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //cách 1:
        // lấy tất cả categories
        $searchCategory = $request->search;
        $categories = Category::query()
            ->when($searchCategory,fn($query,$searchCategory)=>$query
            ->where('title', 'like', '%'.$searchCategory.'%')
            ->orWhere('slug', 'like', '%'.$searchCategory.'%'))
            ->orderBy('id', 'desc')->paginate(10);

        /* cách 2 */
        $categories2 = Category::whereAny(
            [
                'title',
                'slug'
            ],
            'LIKE',
            "%{$searchCategory}%"
        )->orderBy('id', 'desc')->paginate(10);

       // dd($categories, $categories2);


        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // gọi lấy danh sách categories parent
        $categories = Category::where('category_id', null)->get();

        //Debugbar::info($categories);

        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $validated = $request->validated();

        if(!$validated) {
            return redirect()->back()->withErrors($request->errors())->withInput();
        }


        // kiểm tra tồn tại "image" hay không, nếu có, ta sẽ lưu hình ảnh
        $image = null;
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $exection = $file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/', $name);
            $urlImage = URL::to('/').'/uploads/'.$name;
            $image = $urlImage;
        }
        $request->mergeIfMissing(['image' => $image]);
        $category = Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success','Category created successfully');


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
    public function edit(Category $category)
    {
        // gọi lấy danh sách categories parent
        if(!$category) return abort(404);
        $categories = Category::where('category_id', null)->get();
        return view('admin.category.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
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
            $category->image = $image;
        }
        // lấy tất cả dữ liệu từ request , trừ trường "images"
       // $data = $request->except('image');
        // gán mảng data tới category
        //$category->fill($data);

        $category->save();
        //$category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if(!$category){
            return redirect()->route('admin.categories.index')->with('error','Category not found');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success','Category deleted successfully');
    }
}

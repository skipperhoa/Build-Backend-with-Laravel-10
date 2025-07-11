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
            ->when($searchCategory, function ($query, $searchCategory) {
                $query->where(function ($q) use ($searchCategory) {
                    $q->where('title', 'like', "%{$searchCategory}%")
                     ->orWhere('slug', 'like', "%{$searchCategory}%");
                });
            })
            ->when($request->filled('filter'), function ($query) use ($request) {
                if ($request->filter === 'parent') {
                    $query->whereNull('category_id');
                }else if ($request->filter === 'child') {
                    $query->whereNotNull('category_id');
                }
                 else {
                    $query->where('category_id', $request->filter);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        /* cách 2 */
        $categories2 = Category::whereAny(
                ['title', 'slug'],
                'LIKE',
                "%{$searchCategory}%"
        );
        if($request->has('filter')) {
            $filter = $request->filter;
            if($filter != 'parent') {
                $categories2 = $categories2->where('category_id', $filter);
            }else{
                $categories2 = $categories2->WhereNull('category_id');
            }
        }
        $categories2 = $categories2->orderBy('id', 'desc')->paginate(10);

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

        $request->mergeIfMissing(['image' => $category->image]);
        // gán mảng data tới category
        $category->fill($request->all());

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

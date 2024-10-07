<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        if (request()->is('api/*')) {
            return response()->json($categories);
        }
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = Str::slug($filename) . '_' . time();
            $filename .= '.' . $extension;
            $destinationPath = public_path('thumbnails/categories');
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }
            $file->move($destinationPath, $filename);
            $thumbnailPath = 'thumbnails/categories/' . $filename;
        }

        // Tạo danh mục mới
        $category = Category::create($request->only('name', 'description') + ['thumbnail' => $thumbnailPath]);

        if (request()->is('api/*')) {
            return response()->json($category, 201);
        }

        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::where('category_id', $id)->with('category')->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this category.'], 404);
        }

        return response()->json($products);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::find($id);
        return view('admin.category.update', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $thumbnailPath = $category->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $category = Category::findOrFail($id);
            $photoPath = public_path($category->thumbnail);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = Str::slug($filename) . '_' . time();
            $filename .= '.' . $extension;
            $destinationPath = public_path('thumbnails/categories');
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }
            $file->move($destinationPath, $filename);
            $thumbnailPath = 'thumbnails/categories/' . $filename;
        }

        // Cập nhật danh mục
        $category->update($request->only('name', 'description') + ['thumbnail' => $thumbnailPath]);
        if (request()->is('api/*')) {
            return response()->json($category, 200);
        }
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $photoPath = public_path($category->thumbnail);
        if (File::exists($photoPath)) {
            File::delete($photoPath);
        }
        $category->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'Category deleted successfully'], 200);
        }
        return redirect()->route('admin.category.index');
    }
}

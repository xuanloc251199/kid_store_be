<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get(); // Tải thông tin danh mục
        if (request()->is('api/*')) {
            return response()->json($products);
        }
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return response()->view('admin.product.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Create kiểm tra cho file
            'sold' => 'nullable|integer',
            'quantity' => 'required|integer',
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
            $destinationPath = public_path('thumbnails/products');
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }
            $file->move($destinationPath, $filename);
            $thumbnailPath = 'thumbnails/products/' . $filename;
        }
        
        $product = Product::create($request->only('name', 'category_id', 'detail', 'description', 'price', 'sold', 'quantity') + ['thumbnail' => $thumbnailPath]);
        if (request()->is('api/*')) {
            return response()->json($product, 201);
        }

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::find($id);
        $categories = Category::all();
        return view('admin.product.update', compact('products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Create kiểm tra cho file
            'sold' => 'nullable|integer',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $thumbnailPath = $product->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $product = Product::findOrFail($id);
            $photoPath = public_path($product->thumbnail);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = Str::slug($filename) . '_' . time();
            $filename .= '.' . $extension;
            $destinationPath = public_path('thumbnails/products');
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }
            $file->move($destinationPath, $filename);
            $thumbnailPath = 'thumbnails/products/' . $filename;
        }

        $product->update($request->only('name', 'category_id', 'detail', 'description', 'price', 'sold', 'quantity') + ['thumbnail' => $thumbnailPath]);
        if (request()->is('api/*')) {
            return response()->json($product, 200);
        }

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::findOrFail($id);
        $photoPath = public_path($product->thumbnail);
        if (File::exists($photoPath)) {
            File::delete($photoPath);
        }
        $product->delete();
        
        if (request()->is('api/*')) {
            return response()->json(['message' => 'Product deleted successfully'], 200);
        }
        return redirect()->back()->with('success', 'Delete thành công');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class U_ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = Product::with('category')->get(); // Tải thông tin danh mục
        return response()->json($products);
    }

    // Thêm sản phẩm mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|string',
            'sold' => 'nullable|integer',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tạo sản phẩm mới
        $product = Product::create($request->only('name', 'category_id', 'detail', 'description', 'price', 'thumbnail', 'sold', 'quantity'));
        return response()->json($product, 201);
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'detail' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'thumbnail' => 'nullable|string',
            'sold' => 'nullable|integer',
            'quantity' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật sản phẩm
        $product->update($request->only('name', 'category_id', 'detail', 'description', 'price', 'thumbnail', 'sold', 'quantity'));
        return response()->json($product, 200);
    }

    // Hiển thị thông tin sản phẩm theo ID
    public function show($id)
    {
        // Tìm sản phẩm theo ID, bao gồm thông tin danh mục
        $product = Product::with('category')->find($id);

        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}

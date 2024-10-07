<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->get(); // Tải thông tin người dùng và sản phẩm
        if (request()->is('api/*')) {
            return response()->json($reviews);
        }
        return view('admin.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $users = User::all();
        return response()->view('admin.review.create', compact('products', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tạo đánh giá mới
        $review = Review::create($request->only('user_id', 'product_id', 'rating', 'comment'));
        if (request()->is('api/*')) {
            return response()->json($review, 201);
        }
        return redirect()->route('admin.review.index');

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
    public function edit(string $id)
    {
        $users = User::all();
        $products = Product::all();
        $review = Review::find($id);
        return view('admin.review.update', compact('users', 'products', 'review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $review = Review::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật đánh giá
        $review->update($request->only('rating', 'comment'));
        if (request()->is('api/*')) {
            return response()->json($review, 200);
        }
        return redirect()->route(route: 'admin.review.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'Review deleted successfully'], 200);
        }
        return redirect()->route(route: 'admin.review.index');

    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class U_ReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->get(); // Tải thông tin người dùng và sản phẩm
        return response()->json($reviews);
    }

    // Thêm đánh giá mới
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
        return response()->json($review, 201);
    }

    // Cập nhật đánh giá
    public function update(Request $request, $id)
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
        return response()->json($review, 200);
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class U_CartController extends Controller
{
    // Hiển thị giỏ hàng của người dùng
    public function index(Request $request)
    {
        $userId = $request->user()->id; // Lấy ID người dùng đã đăng nhập
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        // Tính tổng số lượng sản phẩm
        $totalQuantity = $cartItems->sum('quantity');
        $totalPrice = $cartItems->reduce(function ($carry, $cartItem) {
            return $carry + ($cartItem->product->price * $cartItem->quantity);
        }, 0);

        return response()->json([
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
            'cart_items' => $cartItems,
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = auth()->id(); // Lấy ID người dùng đã đăng nhập

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            // Nếu sản phẩm đã có, cập nhật số lượng
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa có, tạo mới
            $cartItem = Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json($cartItem, 201);
    }


    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật số lượng
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json($cartItem, 200);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart successfully'], 200);
    }
}

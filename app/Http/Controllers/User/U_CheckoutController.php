<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class U_CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Lấy ID người dùng đã đăng nhập
        $userId = auth()->id();

        // Lấy các mặt hàng trong giỏ hàng của người dùng
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Giỏ hàng trống'], 400);
        }

        // Tính tổng số tiền của đơn hàng
        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => 'completed',
        ]);

        // Lặp qua từng mặt hàng trong giỏ hàng và thêm vào bảng order_items
        foreach ($cartItems as $cartItem) {
            // Thêm mặt hàng vào bảng order_items
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            // Trừ số lượng sản phẩm tương ứng trong bảng products
            $product = Product::find($cartItem->product_id);

            if ($product && $product->quantity >= $cartItem->quantity) {
                $product->quantity -= $cartItem->quantity;
                $product->save();
            } else {
                return response()->json(['message' => 'Số lượng sản phẩm không đủ'], 400);
            }
        }

        // Xóa giỏ hàng sau khi tạo đơn hàng thành công
        Cart::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Thanh toán thành công', 'order' => $order], 200);
    }
}

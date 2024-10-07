<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('product', 'user')->get();
        return view('admin.cart.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return response()->view('admin.cart.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = $request->user()->id; // Lấy ID người dùng đã đăng nhập

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

        if (request()->is('api/*')) {
            return response()->json($cartItem, 201);
        }
        return redirect()->route('admin.cart.index');
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
        $cart = Cart::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.cart.update', compact('cart', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = Cart::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (request()->is('api/*')) {
            $cartItem = Cart::findOrFail($id);

            // Cập nhật số lượng
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return response()->json($cartItem, 200);
        }

        $cart->update($request->only('product_id', 'user_id', 'quantity'));
        return redirect()->route('admin.cart.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'Item removed from cart successfully'], 200);
        }
        return redirect()->route('admin.cart.index');
    }
}
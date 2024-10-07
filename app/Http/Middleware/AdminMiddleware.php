<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Chuyển hướng đến trang đăng nhập admin nếu chưa đăng nhập
            return redirect()->route('admin.login');
        }

        // Kiểm tra nếu người dùng không phải admin
        if (Auth::user()->role_id !== 1) {
            return redirect('/'); // Hoặc trang bạn muốn
        }

        return $next($request);
    }
}

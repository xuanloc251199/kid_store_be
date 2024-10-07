<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Nếu là yêu cầu từ API, trả về lỗi 401 Unauthorized thay vì chuyển hướng
        if ($request->expectsJson()) {
            return null;  // Không chuyển hướng, Laravel sẽ trả về lỗi 401
        }

        // Kiểm tra nếu yêu cầu đến từ trang admin
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login'); // Chuyển hướng đến trang admin login
        }

        return null; // Không chuyển hướng cho người dùng thông thường
    }
}

<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\User\U_AuthController;
use App\Http\Controllers\User\U_CategoryController;
use App\Http\Controllers\User\U_ProductController;
use App\Http\Controllers\User\U_TicketController;
use App\Http\Controllers\User\U_UserController;
use App\Http\Controllers\User\U_ReviewController;
use App\Http\Controllers\User\U_CartController;
use App\Http\Controllers\User\U_CheckoutController;
// routes/api.php
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

####################### User #######################

## Auth ##

## Auth ##
Route::prefix('u')->group(function () {
    Route::post('/register', [U_AuthController::class, 'register']);
    Route::post('/login', [U_AuthController::class, 'login']);
    Route::post('/logout', [U_AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/profile', [U_AuthController::class, 'showProfile'])->middleware('auth:sanctum');
    Route::put('/update', [U_AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
});

## User ##
Route::prefix('u')->group(function () {
    Route::get('/user', [U_UserController::class, 'show'])->middleware('auth:sanctum');

    // Route để thêm người dùng mới (có thể không cần bảo mật)
    Route::post('/user/store', [U_UserController::class, 'store']);

    // Route để cập nhật người dùng
    Route::put('/user/update', [U_UserController::class, 'update'])->middleware('auth:sanctum');

    // Route để xóa người dùng
    Route::delete('/user/{id}', [U_UserController::class, 'destroy'])->middleware('auth:sanctum');
});

## Category ##
Route::prefix('u')->group(function () {
    // Route để hiển thị danh sách danh mục
    Route::get('/categories', [U_CategoryController::class, 'index']);

    // Route để thêm danh mục mới
    Route::post('/categories/store', [U_CategoryController::class, 'store']);

    // Route để cập nhật danh mục
    Route::put('/categories/update/{id}', [U_CategoryController::class, 'update']);

    // Route để xóa danh mục
    Route::delete('/categories/destroy/{id}', [U_CategoryController::class, 'destroy']);

    // Route để hiển thị sản phẩm theo danh mục
    Route::get('/categories/{id}/products', [U_CategoryController::class, 'getProductsByCategory']);
});
## Product ##
Route::prefix('u')->group(function () {
    // Route để hiển thị danh sách sản phẩm
    Route::get('/products', [U_ProductController::class, 'index']);

    // Route để thêm sản phẩm mới
    Route::post('/products/store', [U_ProductController::class, 'store']);

    // Route để cập nhật sản phẩm
    Route::put('/products/update/{id}', [U_ProductController::class, 'update']);

    // Route để xóa sản phẩm
    Route::delete('/products/destroy/{id}', [U_ProductController::class, 'destroy']);

    Route::get('/products/{id}', [U_ProductController::class, 'show']);
});
## Tickets ##
Route::prefix('u')->group(function () {
    // Route để hiển thị danh sách vé
    Route::get('/tickets', [U_TicketController::class, 'index']);

    // Route để thêm vé mới
    Route::post('/tickets/store', [U_TicketController::class, 'store']);

    // Route để cập nhật vé
    Route::put('/tickets/update/{id}', [U_TicketController::class, 'update']);

    // Route để xóa vé
    Route::delete('/tickets/destrou/{id}', [U_TicketController::class, 'destroy']);
});
## Review ##
Route::prefix('u')->group(function () {
    // Route để hiển thị danh sách đánh giá
    Route::get('/reviews', [U_ReviewController::class, 'index']);

    // Route để thêm đánh giá mới
    Route::post('/reviews/store', [U_ReviewController::class, 'store']);

    // Route để cập nhật đánh giá
    Route::put('/reviews/update/{id}', [U_ReviewController::class, 'update']);

    // Route để xóa đánh giá
    Route::delete('/reviews/destroy/{id}', [U_ReviewController::class, 'destroy']);
});
## Cart ##
Route::prefix('u')->group(function () {
    // Route để hiển thị giỏ hàng
    Route::get('/cart', [U_CartController::class, 'index'])->middleware('auth:sanctum');

    // Route để thêm sản phẩm vào giỏ hàng
    Route::post('/cart/store', [U_CartController::class, 'store'])->middleware('auth:sanctum');

    // Route để cập nhật số lượng sản phẩm trong giỏ hàng
    Route::put('/cart/update/{id}', [U_CartController::class, 'update'])->middleware('auth:sanctum');

    // Route để xóa sản phẩm khỏi giỏ hàng
    Route::delete('/cart/destroy/{id}', [U_CartController::class, 'destroy'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/checkout', [U_CheckoutController::class, 'checkout']);
    });
});

####################### Admin #######################
// Route::prefix('user')->group(function () {
//     Route::get('', [UserController::class, 'show'])->middleware('auth:sanctum');
//     Route::post('/store', [UserController::class, 'store']);
//     Route::put('/update', [UserController::class, 'update'])->middleware('auth:sanctum');
//     Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');
// });


// Route::prefix('categories')->group(function () {
//     Route::get('', [CategoryController::class, 'index']);
//     Route::post('/store', [CategoryController::class, 'store']);
//     Route::put('/update/{id}', [CategoryController::class, 'update']);
//     Route::delete('/destroy/{id}', [CategoryController::class, 'destroy']);
//     Route::get('/{id}/products', [CategoryController::class, 'show']);
// });

// Route::prefix('product')->group(function () {
//     Route::get('', [ProductController::class, 'index']);
//     Route::post('/store', [ProductController::class, 'store']);
//     Route::put('/update/{id}', [ProductController::class, 'update']);
//     Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
// });

// Route::prefix('ticket')->group(function () {
//     Route::get('', [TicketController::class, 'index']);
//     Route::post('/store', [TicketController::class, 'store']);
//     Route::put('/update/{id}', [TicketController::class, 'update']);
//     Route::delete('/destroy/{id}', [TicketController::class, 'destroy']);
// });

// Route::prefix('review')->group(function () {
//     Route::get('', [ReviewController::class, 'index']);
//     Route::post('/store', [ReviewController::class, 'store']);
//     Route::put('/update/{id}', [ReviewController::class, 'update']);
//     Route::delete('/destroy/{id}', [ReviewController::class, 'destroy']);
// });

// Route::prefix('cart')->group(function () {
//     Route::get('', [CartController::class, 'index']);
//     Route::post('/store', [CartController::class, 'store']);
//     Route::put('/update/{id}', [CartController::class, 'update']);
//     Route::delete('/destroy/{id}', [CartController::class, 'destroy']);
// });

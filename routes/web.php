<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\U_AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {

    Route::get('', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

     // User
     Route::resource('/user', UserController::class)->names([
        'index' => 'admin.user.index',
        'create' => 'admin.user.create',
        'store' => 'admin.user.store',
        'edit' => 'admin.user.edit',
        'update' => 'admin.user.update',
        'destroy' => 'admin.user.destroy',
    ]);

    // Category
    Route::resource('/category', CategoryController::class)->names([
        'index' => 'admin.category.index',
        'create' => 'admin.category.create',
        'store' => 'admin.category.store',
        'edit' => 'admin.category.edit',
        'update' => 'admin.category.update',
        'destroy' => 'admin.category.destroy',
    ]);

    // Products
    Route::resource('/product', ProductController::class)->names([
        'index' => 'admin.product.index',
        'create' => 'admin.product.create',
        'store' => 'admin.product.store',
        'edit' => 'admin.product.edit',
        'update' => 'admin.product.update',
        'destroy' => 'admin.product.destroy',
    ]);

    // Review
    Route::resource('/review', ReviewController::class)->names([
        'index' => 'admin.review.index',
        'create' => 'admin.review.create',
        'store' => 'admin.review.store',
        'edit' => 'admin.review.edit',
        'update' => 'admin.review.update',
        'destroy' => 'admin.review.destroy',
    ]);

    // Cart
    Route::resource('/cart', CartController::class)->names([
        'index' => 'admin.cart.index',
        'create' => 'admin.cart.create',
        'store' => 'admin.cart.store',
        'edit' => 'admin.cart.edit',
        'update' => 'admin.cart.update',
        'destroy' => 'admin.cart.destroy',
    ]);

    // Ticket
    Route::resource('/ticket', TicketController::class)->names([
        'index' => 'admin.ticket.index',
        'create' => 'admin.ticket.create',
        'store' => 'admin.ticket.store',
        'edit' => 'admin.ticket.edit',
        'update' => 'admin.ticket.update',
        'destroy' => 'admin.ticket.destroy',
    ]);
});

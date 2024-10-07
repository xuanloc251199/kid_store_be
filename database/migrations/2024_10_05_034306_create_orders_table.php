<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Tự động tạo khóa chính
            $table->unsignedBigInteger('user_id'); // ID người dùng
            $table->decimal('total_amount', 10, 2); // Tổng số tiền của đơn hàng
            $table->string('status')->default('pending'); // Trạng thái của đơn hàng, ví dụ: pending, paid, shipped
            $table->timestamps(); // Thêm cột created_at và updated_at

            // Thiết lập khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}

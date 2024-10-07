<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class U_UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::with('role')->get(); // Tải thông tin vai trò
        return response()->json($users);
    }

    // Hiển thị thông tin
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    // Cập nhật người dùng
    public function update(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $user = $request->user();

        // Kiểm tra xem người dùng có tồn tại hay không
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8', // Thêm điều kiện nullable và min length
            'role_id' => 'nullable|exists:roles,id',
            'number_phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật thông tin người dùng
        $user->update($request->only('name', 'email', 'number_phone', 'address'));

        // Nếu có mật khẩu mới, mã hóa và lưu lại
        if ($request->has('password') && !empty($request->password)) {
            $user->password = bcrypt($request->password); // Mã hóa mật khẩu
        }

        // Xử lý upload avatar nếu có
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                $oldAvatarPath = public_path($user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath); // Xóa file cũ
                }
            }

            $file = $request->file('avatar');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = Str::slug($filename) . '_' . time(); // Tạo tên file an toàn
            $filename .= '.' . $extension;

            $destinationPath = public_path('avatars'); // Thư mục lưu trữ avatar
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }

            $file->move($destinationPath, $filename); // Lưu file vào thư mục
            $user->avatar = 'avatars/' . $filename; // Cập nhật đường dẫn avatar mới
        }

        $user->save(); // Lưu tất cả thông tin đã cập nhật

        return response()->json($user, 200);
    }


    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}

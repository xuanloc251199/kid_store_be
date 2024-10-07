<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->get();
        if (request()->is('api/*')) {
            return response()->json($users);
        }
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return response()->view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer',
            'number_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Xử lý upload avatar nếu có
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
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
            $avatarPath = 'avatars/' . $filename; // Lưu đường dẫn avatar
        }

        // Tạo user mới
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash password
            'remember_token' => Str::random(10),
            'role_id' => $request->role_id,
            'number_phone' => $request->number_phone,
            'address' => $request->address,
            'avatar' => $avatarPath, // Lưu đường dẫn avatar vào cơ sở dữ liệu
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trả về thông báo thành công
        return redirect()->route('admin.user.index')->with('success', 'Tạo người dùng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        return response()->json($request->user());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::get();
        $user = User::with('role')->find($id);
        return view('admin.user.update', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Lấy thông tin người dùng hiện tại
        $user = User::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes',
            'role_id' => 'nullable|exists:roles,id',
            'number_phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Thêm quy tắc cho avatar
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật thông tin người dùng
        $user->update($request->only('name', 'email', 'role_id', 'number_phone', 'address'));

        // Nếu có mật khẩu mới, mã hóa và lưu lại
        if ($request->has('password') && !empty($request->password)) {
            $user->password = bcrypt($request->password); // Sử dụng bcrypt để mã hóa mật khẩu
        }

        // Xử lý upload avatar nếu có
        $avatarPath = null;
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
            $avatarPath = 'avatars/' . $filename; // Lưu đường dẫn avatar
            $user->avatar = $avatarPath; // Cập nhật đường dẫn avatar mới
        }

        $user->save(); // Lưu tất cả thông tin đã cập nhật

        if (request()->is('api/*')) {
            return response()->json($user, 200);
        }
        return redirect()->route('admin.user.index')->with('success', 'Sửa người dùng thành công!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'User deleted successfully'], 200);
        }
        return redirect()->route('admin.user.index')->with('success', 'Xoá người dùng thành công!');
    }
}

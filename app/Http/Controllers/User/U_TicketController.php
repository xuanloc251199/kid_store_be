<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class U_TicketController extends Controller
{
    // Hiển thị danh sách vé
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets);
    }

    // Thêm vé mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'detail' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'number_ticket' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tạo vé mới
        $ticket = Ticket::create($request->only('name', 'place', 'date', 'detail', 'description', 'price', 'number_ticket'));
        return response()->json($ticket, 201);
    }

    // Cập nhật vé
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'place' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'detail' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'number_ticket' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật vé
        $ticket->update($request->only('name', 'place', 'date', 'detail', 'description', 'price', 'number_ticket'));
        return response()->json($ticket, 200);
    }

    // Xóa vé
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }
}

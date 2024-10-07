<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        if (request()->is('api/*')) {
            return response()->json($tickets);
        }
        return view('admin.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
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

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = Str::slug($filename) . '_' . time();
            $filename .= '.' . $extension;
            $destinationPath = public_path('thumbnails/tickets');
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }
            $file->move($destinationPath, $filename);
            $thumbnailPath = 'thumbnails/tickets/' . $filename;
        }

        // Tạo vé mới
        $ticket = Ticket::create($request->only('name', 'place', 'date', 'detail', 'description', 'price', 'number_ticket') + ['thumbnail' => $thumbnailPath]);
        if (request()->is('api/*')) {
            return response()->json($ticket, 201);
        }
        return redirect()->route('admin.ticket.index');
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
        $ticket = Ticket::find($id);
        return view('admin.ticket.update', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
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

        $thumbnailPath = $ticket->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $ticket = Ticket::findOrFail($id);
            $photoPath = public_path($ticket->thumbnail);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = Str::slug($filename) . '_' . time();
            $filename .= '.' . $extension;
            $destinationPath = public_path('thumbnails/tickets');
            while (file_exists($destinationPath . '/' . $filename)) {
                $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '_' . rand(1, 1000) . '.' . $extension;
            }
            $file->move($destinationPath, $filename);
            $thumbnailPath = 'thumbnails/tickets/' . $filename;
        }
        
        // Cập nhật vé
        $ticket->update($request->only('name', 'place', 'date', 'detail', 'description', 'price', 'number_ticket') + ['thumbnail' => $thumbnailPath]);
        if (request()->is('api/*')) {
            return response()->json($ticket, 200);
        }
        return redirect()->route('admin.ticket.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'Ticket deleted successfully'], 200);
        }
        return redirect()->route('admin.ticket.index');
    }
}

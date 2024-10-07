<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class U_PaymentController extends Controller
{
    public function showForm()
    {
        return view('payment_demo');
    }

    public function processPayment(Request $request)
    {
        // Lấy thông tin từ form thanh toán
        $cardNumber = $request->input('card_number');
        $expiryDate = $request->input('expiry_date');
        $cvv = $request->input('cvv');
        $amount = $request->input('amount');

        // Kiểm tra thẻ và thông tin thanh toán (giả lập)
        if ($this->isValidCard($cardNumber, $expiryDate, $cvv)) {
            // Thanh toán thành công
            return redirect()->back()->with('success', 'Thanh toán thành công! Số tiền: ' . $amount . ' VND');
        } else {
            // Thanh toán thất bại
            return redirect()->back()->with('success', 'Thanh toán thất bại. Vui lòng kiểm tra lại thông tin thẻ.');
        }
    }

    // Hàm kiểm tra thẻ hợp lệ (giả lập)
    private function isValidCard($cardNumber, $expiryDate, $cvv)
    {
        // Chỉ cần thẻ bắt đầu với '1234' là hợp lệ (ví dụ)
        if (strpos($cardNumber, '1234') === 0 && strlen($cvv) == 3) {
            return true;
        }
        return false;
    }
}

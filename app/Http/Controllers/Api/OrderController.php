<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Validators\OrderValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class OrderController extends Controller
{
    public function postAction(Request $request) {
        $request->merge(['code' => generateRandomString(12, 'code')]);
        $validator = OrderValidator::postValidation($request);
        if ($validator->fails()) return response()->json(['message' => $validator->errors()], 422);

        try {
            $order = Order::create([
                'code' =>  $request->code,
                'user_id' => Auth::id(),
                'product_name' => $request->product_name,
                'payment_at' => Carbon::now()->timezone('Asia/Seoul'),
            ]);

            $res['data'] = $order;
            $res['message'] = '주문에 성공했습니다.';
            $resCode = 201;
        } catch (Exception $e) {
            $res['message'] = '주문에 실패했습니다.';
            $resCode = 500;
        }

        return response()->json($res, $resCode);
    }
}

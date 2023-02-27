<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControlle extends Controller
{
    public function postLoginAction(Request $request) {
        $validator = UserValidator::postLoginValidation($request);
        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $res['data']['name'] = $user->name;
            $res['data']['token'] = $user->createToken('accessToken')->accessToken;
            $res['message'] = '로그인에 성공했습니다.';

            return response()->json($res, 200);
        } else {
            return response()->json(['error' => '로그인에 실패했습니다.'], 401);
        }
    }
}

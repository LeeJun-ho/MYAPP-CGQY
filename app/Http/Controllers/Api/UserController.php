<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Validators\UserValidator;

class UserController extends Controller
{
    public function postSignupAction(Request $request) {
        $validator = UserValidator::postSignupValidation($request);
        
        if ($validator->fails()) return response()->json($validator->errors(), 422);

        try {
            $user = User::create([
                'name' => $request->name,
                'nickname' => $request->nickname,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $request->gender ? $request->gender : null,
            ]);
            error_log($user);

            $res['data'] = $user;
            $res['message'] = '회원 등록에 성공했습니다.';
            $resCode = 201;
        } catch (Exception $e) {
            $res['message'] = '회원 등록에 실패했습니다.';
            $resCode = 500;
        }

        return response()->json($res, $resCode);
    }
}

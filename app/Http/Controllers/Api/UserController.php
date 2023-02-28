<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UserController extends Controller
{
    public function postSignupAction(Request $request) {
        $validator = UserValidator::postSignupValidation($request);
        if ($validator->fails()) return response()->json(['message' => $validator->errors()], 422);

        try {
            $user = User::create([
                'name' => $request->name,
                'nickname' => $request->nickname,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $request->gender ? $request->gender : null,
            ]);

            $res['data'] = $user;
            $res['message'] = '회원 등록에 성공했습니다.';
            $resCode = 201;
        } catch (Exception $e) {
            $res['message'] = '회원 등록에 실패했습니다.';
            $resCode = 500;
        }

        return response()->json($res, $resCode);
    }

    public function getMyInfoAction() {
        return response()->json([
            'data' => Auth::user(),
        ], 200);
    }

    public function getMyOrdersAction() {
        return response()->json([
            'data' => Auth::user()->orders()->paginate(10),
        ], 200);
    }

    public function getCollectionAction(Request $request) {
        $query = User::query();
        if ($request->get('keyword')) {
            $query
                ->where('name', 'like', '%'.$request->get('keyword').'%')
                ->orWhere('email', 'like', '%'.$request->get('keyword').'%');
        }

        $users = $query->paginate(10);
        foreach ($users as $user) {
            if ($user->id) {
                $user['latest_order'] = $user->latestOrder;
            }
        }

        return response()->json([
            'data' => $users,
        ], 200);
    }

    public function getAction($id) {
        try {
            $res['data'] = User::findOrFail($id);
            $resCode = 200;
        } catch(ModelNotFoundException $e) {
            error_log($e);
            $res['message'] = '존재하지 않는 사용자입니다.';
            $resCode = 404;
        } catch (Exception $e) {
            error_log($e);
            $res['message'] = '사용자 조회에 실패하였습니다.';
            $resCode = 500;
        }

        return response()->json($res, $resCode);
    }

    public function getOrdersAction($id) {
        try {
            $res['data'] = User::findOrFail($id)->orders()->paginate(10);
            $resCode = 200;
        } catch(ModelNotFoundException $e) {
            error_log($e);
            $res['message'] = '존재하지 않는 사용자입니다.';
            $resCode = 404;
        } catch (Exception $e) {
            error_log($e);
            $res['message'] = '주문 조회에 실패하였습니다.';
            $resCode = 500;
        }

        return response()->json($res, $resCode);
    }
}

<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserValidator
{
    public static function postLoginValidation(Request $request) {
        return Validator::make($request->all(), [
            'email' => ['required','email','max:100'],
            'password' => ['required','min:10','max:20'],
        ]);
    }

    public static function postSignupValidation(Request $request) {
        return Validator::make($request->all(), [
            'name' => ['required','regex:/^[가-힣a-zA-Z\s]+$/','max:20'],
            'nickname' => ['required','regex:/^[a-z\s]+$/','max:30'],
            'password' => ['required','regex:/^.*(?=.{4,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).*$/','min:10','max:20'],
            'email' => ['required','email','max:100','unique:mysql::write.users'],
            'phone' => ['required','regex:/^[0-9\s]+$/','max:20'],
            'gender' => [Rule::in(['F', 'M'])],
        ]);
    }
}
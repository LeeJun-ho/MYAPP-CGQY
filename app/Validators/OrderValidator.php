<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderValidator
{
    public static function postValidation(Request $request) {
        return Validator::make($request->all(), [
            'code' => ['required','min:12','max:12','unique:mysql::write.orders'],
            'product_name' => ['required','max:100'],
        ]);
    }
}
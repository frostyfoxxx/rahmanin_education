<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function singup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['required', 'string', 'max:11'],
            'email' => ['required', 'string'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        $user = User::query()->where('phone_number', '=', $request->input('phone_number'))->orWhere('email', '=' . $request->input('email'))->first();
        if ($user) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => "The user with this number or email address is already registered"
                ]
            ], 402);
        }

         User::create($request->all());

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Users has benn created"
            ]
        ], 201);
    }
}

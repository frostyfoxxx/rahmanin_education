<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(Request $request)
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
                    'message' => "Пользователь с таким телефоном и/или e-mail уже зарегистрирован"
                ]
            ], 422);
        }

        $user = User::create([
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'stuff' => false
        ]);

        $user->roles()->attach(Role::where('slug', 'student')->first());
        $user->save();

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Пользователь успешно создан"
            ]
        ], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['required', 'numeric', 'digits:11'],
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

        if (!Auth::attempt($request->all())) {
           return response()->json([
               'error' => [
                   'code' => 401,
                   "message" => 'This user not register'
               ]
           ], Response::HTTP_UNAUTHORIZED );
        }

        $user = Auth::user();
        $role = auth('sanctum')->user()->roles[0]->slug;
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24 * 7); // 7 day

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => "Аутентифицирован",
                'role' => $role,
            ]
        ], 200)->withCookie($cookie);

    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return auth('sanctum')->user();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $cookie = Cookie::forget('jwt');

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => 'Logout success'
            ]
        ])->withCookie($cookie);
    }
}

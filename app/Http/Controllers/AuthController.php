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
            'phone_number' => ['required', 'string', 'digits:11'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::query()
            ->where('phone_number', '=', $request->input('phone_number'))
            ->orWhere('email', '=', $request->input('email'))
            ->first();
        if ($user) {
            return response()->json([
                'code' => 400,
                'message' => "Пользователь с таким телефоном и/или e-mail уже зарегистрирован"
            ], 400);
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
            'code' => 201,
            'message' => "Пользователь успешно создан"
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
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json([
                'code' => 401,
                "message" => 'Ошибка логина и/или пароля'

            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        if ($user->reject == true) {
            return response()->json([
                'code' => 403,
                'message' => 'Доступ запрещен'
            ], 403);
        }

        $role = auth('sanctum')->user()->roles[0]->slug;
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'code' => 200,
            'message' => "Аутентифицирован",
            'role' => $role
        ], 200)->withHeaders(['Authorization' => 'Bearer ' . $token]);
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
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Успешный выход'

        ], 200);
    }
}

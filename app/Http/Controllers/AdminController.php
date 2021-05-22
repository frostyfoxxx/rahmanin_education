<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminCreateUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'login' => 'required|string|max:11',
            'password' => 'required',
            'modules' => 'array',
            'modules.*.name' => 'required|string',
            'modules.*.root' => 'required|string|exists:roles,name'
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

        $user = User::create([
            'phone_number' => $request->input('login'),
            'password' => Hash::make($request->input('password')),
            'stuff' => true

        ]);

        Admin::create([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'user_id' => $user->id
        ]);

        $count = count($request->modules);

        for ($i = 0; $i < $count; $i++) {

            $user->roles()->attach(Role::where('name', $request->modules[$i]['root'])->first());
            $user->save();
        }

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Сотрудник создан"
            ]
        ], 201);


    }

    public function CreateRole(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'slug' => 'required|max:50',

        ]);
        $user = Role::create([

            'name' => $request->input('name'),
            'slug' => $request->input('slug'),

        ]);
        $user->save();
        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Роль создана"
            ]
        ], 201);

    }

    public function createAdmin(Request $request)
    {
        $user = User::create([
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
            'stuff' => true
        ]);
        $user->roles()->attach(Role::where('slug', 'admin')->first());
        $user->save();

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Профиль администратора создан'
            ]
        ], 201);
    }
}

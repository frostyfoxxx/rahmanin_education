<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function getInfoEducation()
    {
        $options = Options::find(1);
        return response()->json([
            'code' => 200,
            'message' => 'Информация найдена',
            'content' => [
                [
                    'name' => $options->name_education,
                    'name_short' => $options->name_short,
                    'region' => $options->region,
                    'director_name' => $options->director_name
                ]
            ]
        ], 200);
    }

    public function postInfoEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_short' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'region' => 'required|numeric',
            'director_name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации'
            ], 422);
        }

        Options::create([
            'name_education' => $request->name,
            'name_short' => $request->name_short,
            'region' => $request->region,
            'address_education' => $request->address,
            'director_name' => $request->director_name,
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'Базовая информация об образовательном учреждении добавлена'
        ], 201);
    }

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
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
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
            'code' => 201,
            'message' => "Сотрудник создан"
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
            'code' => 201,
            'message' => 'Профиль администратора создан'
        ], 201);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminCreateUser(Request $request){

        $validator = Validator::make($request->all(), [
            //'first_name' => 'required',
           // 'middle_name' => 'required',
           // 'last_name' => 'required',
            //'login' => 'required'
            //'password' => 'required'
            //'modules' => 'array'
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
            //'first_name' => $request->input('first_name'),
           // 'middle_name' => $request->input('middle_name'),
           // 'last_name' =>($request->input('last_name'),
           'phone_number' => $request->input('login'),
           'password' => Hash::make($request->input('password')),
           'email' => $request->input('email')
           // 'modules' => $request->input('modules'),
        ]);

        $count = count($request->modules);

        for($i = 0; $i<$count; $i++) {

        $user->roles()->attach(Role::where('slug', $request->modules[$i]['slug'])->first());
        $user->save();
        }

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Users has been created"
            ]
        ], 201);


      }
      public function CreateRole(Request $request) {

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
}

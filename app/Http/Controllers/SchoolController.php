<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function search(Request $request, $id):JsonResponse
    {
        return response()->json([
            'message' => 'Ма держи',
            'code'=>400,
            $school = School::where("user_id", $request->$id)->get()
        ], 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request, $id):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'number_of_classes' => 'required|string|max:255',
            'year_of_ending' => 'required|string|max:255',
            'number_of_certificate' => 'required|string|max:255',
            'number_of_photo' => 'required|string|max:255',
            'version_of_the_certificate' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка запроса'
                ]
            ], 422);
        }
        $school = School::create([
            'school_name' => $request->school_name,
            'number_of_classes' => $request->number_of_classes,
            'year_of_ending'=>$request->year_of_ending,
            'number_of_certificate'=>$request->number_of_certificate,
            'number_of_photo'=>$request->number_of_photo,
            'version_of_the_certificate'=>$request->version_of_the_certificate,
        ])->save();
        return response()->json([
           'code'=>200,
           'school'=>$school,
        ],200);
    }
}

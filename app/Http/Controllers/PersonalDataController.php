<?php

namespace App\Http\Controllers;

use App\Models\PersonalData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalDataController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function search(Request $request, $id): JsonResponse
    {
        return response()->json([
            'message' => 'Ма держи',
            'code' => 400,
            $personalData = PersonalData::where("user_id", $request->$id)->get()
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'orphan' => 'required|string|max:255',
            'childhood_disabled' => 'required|string|max:255',
            'the_large_family' => 'required|string|max:255',
            'hostel_for_students' => 'required|string|max:255',
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
        $personalData = PersonalData::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'orphan' => $request->orphan,
            'childhood_disabled' => $request->childhood_disabled,
            'the_large_family' => $request->the_large_family,
            'hostel_for_students' => $request->hostel_for_students,
        ])->save();
        return response()->json([
            'code' => 200,
            'school' => $personalData,
        ], 200);
    }
}

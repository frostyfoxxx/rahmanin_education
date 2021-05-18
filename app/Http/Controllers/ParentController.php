<?php

namespace App\Http\Controllers;

use App\Models\FirstParent;
use App\Models\Parents;
use App\Models\SecondParent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function search(Request $request, $id): JsonResponse
    {
        $parents = Parents::where('user_id', $request->$id);
        $idParent = collect($parents->toArray())->only(['id']);
        $firstParentId = Parents::where('first_parent_id', $idParent);
        $secondParentId = Parents::where('second_parent_id', $idParent);
        return response()->json([
            'code' => 400,
            $firstParent = FirstParent::where('id', $firstParentId)->get(),
            $secondParent = FirstParent::where('id', $secondParentId)->get(),
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addFirstParent(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
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
        $firstParent = FirstParent::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
        ])->save();
        return response()->json([
            'additionalEducation' => $firstParent,
            'code' => 201,
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addSecondParent(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
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
        $secondParent = SecondParent::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
        ])->save();
        return response()->json([
            'additionalEducation' => $secondParent,
            'code' => 201,
        ], 201);
    }
}

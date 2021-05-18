<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppraisalController extends Controller
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
            $appraisal = Appraisal::where("user_id", $request->$id)->get()->values()->all(),
        ], 201);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|255',
            'appraisal' => 'required|string|255'
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
        $appraisal = Appraisal::create([
            'subject' => $request->subject,
            'appraisal' => $request->appraisal,
        ])->save();
        return response()->json([
            'code' => 200,
            'school' => $appraisal,
        ], 200);
    }
}

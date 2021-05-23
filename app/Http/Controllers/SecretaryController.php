<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use App\Models\QualificationClassifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecretaryController extends Controller
{
    public function createQuota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "code" => ['required', 'string', 'exists:specialty_classifier,code'],
            "specialty" => ['required', 'string', 'exists:specialty_classifier,specialty'],
            "qualification"  => ['required', "string", "exists:qualification_classifier,qualification"],
            "ft_budget_quota" => ['required', 'numeric'],
            "rm_budget_quota" => ['required', 'numeric'],
            "working_profession" => ['required', 'boolean'],
            "budget" => ['required', 'boolean'],
            "commercial" => ['required', 'boolean']
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => "Ошбика валидации",
                    "errors" => $validator->errors()
                ]
            ]);
        }

        $qualification = QualificationClassifier::where('qualification', $request->qualification)->first();

        Qualification::create([
            "qualification_classifier_id" => $qualification->id,
            "ft_budget_quota" => $request->ft_budget_quota,
            "rm_budget_quota" => $request->rm_budget_quota,
            "working_profession" => $request->working_profession,
            "budget" => $request->budget,
            "commercial" => $request->commercial
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => "Квота создана"
            ]
        ], 201);
    }
}

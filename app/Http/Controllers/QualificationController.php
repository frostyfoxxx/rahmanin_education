<?php

namespace App\Http\Controllers;

use App\Http\Resources\CodeSpecialtyResource;
use App\Http\Resources\QualificationClassifierResource;
use App\Models\QualificationClassifier;
use App\Models\SpecialtyClassifier;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    //

    public function getCode()
    {
        return response()->json([
            'data' => [
                'code' => 200,
                'content' => SpecialtyClassifier::all('code')
            ]
        ], 200);
    }

    public function getQualification(Request $request) // TODO: Сделать не через костыль
    {
        $qualification = QualificationClassifier::whereHas('getSpecialty' , function (Builder $query) use ($request) {
            $query->where('code', '=', $request->code);
        })->get();

        $specialty = SpecialtyClassifier::where('code', $request->code)->first();
        return response()->json([
            'data' => [
                'code' => 200,
                'content' => [
                    'specialty' => $specialty->specialty,
                    'qualifications' => QualificationClassifierResource::collection($qualification)
                ]
            ]
        ]);
    }
}

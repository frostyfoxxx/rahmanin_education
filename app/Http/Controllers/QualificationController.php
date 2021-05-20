<?php

namespace App\Http\Controllers;

use App\Http\Resources\CodeSpecialtyResource;
use App\Models\SpecialtyClassifier;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    //

    public function getCode()
    {
        return response()->json([
            'data' => [
                'code' => 200,
                'content' => CodeSpecialtyResource::collection(SpecialtyClassifier::all())
            ]
        ], 200);
    }

    public function getQualification()
    {

    }
}

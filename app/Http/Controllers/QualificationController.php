<?php

namespace App\Http\Controllers;

use App\Http\Resources\QualificationClassifierResource;
use App\Http\Resources\QuotaResource;
use App\Models\Qualification;
use App\Models\QualificationClassifier;
use App\Models\SpecialtyClassifier;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
    public function getQualificationQuota()
    {
        return response()->json([
            'data' => [
                'code' => 200,
                'message' => "Квоты получены",
                'content' => QuotaResource::collection(Qualification::all())
            ]
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSAdjustDetailsTransformers;
use App\AHSAdjustDetails;

class AHSAdjustDetailsController extends Controller
{
    protected $transformer = AHSAdjustDetailsTransformers::Class;

    public function index()
    {
        $ahs_details_adjust = AHSAdjustDetails::all();
        $response = $this->generateCollection($ahs_details_adjust);
        return $this->sendResponse($response,200);
    }
}

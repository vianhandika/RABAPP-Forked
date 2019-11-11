<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSDetailsTransformers;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;

class AHSDetailsController extends RestController
{
    protected $transformer = AHSDetailsTransformers::Class;

    public function index()
    {
        $ahs_details = AHSDetails::all();
        $response = $this->generateCollection($ahs_details);
        return $this->sendResponse($response,200);
    }
}

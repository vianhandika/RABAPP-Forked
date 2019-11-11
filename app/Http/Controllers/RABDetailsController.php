<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RABDetails;
use App\Transformers\RABDetailsTransformers;

class RABDetailsController extends RestController
{
    protected $transformer = RABDetailsTransformers::Class;

    public function index()
    {
        $rab_details = RABDetails::all();
        $response = $this->generateCollection($rab_details);
        return $this->sendResponse($response,200);
    }
}

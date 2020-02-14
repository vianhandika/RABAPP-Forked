<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSLokalDetailsTransformers;
use App\AHSLokalDetails;
use App\AHSLokal;

class AHSLokalDetailsController extends RestController
{
    protected $transformer = AHSLokalDetailsTransformers::Class;

    public function index()
    {
        $ahs = AHSLokalDetails::all();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function showByID($id)
    {
        $ahs = AHSLokalDetails::where('id_ahs_lokal',$id)->get();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function destroy($id)
    {
        $ahs = AHSLokalDetails::findOrfail($id);
        $status = $ahs->delete();
        return response()->json([
            'status' => $status,
            'msg' => $status ? 'Error' : 'Deleted'
        ]);
    }
}

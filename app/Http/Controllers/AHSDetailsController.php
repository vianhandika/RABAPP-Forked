<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSDetailsTransformers;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;
use App\AHS; 

class AHSDetailsController extends RestController
{
    protected $transformer = AHSDetailsTransformers::Class;

    public function index()
    {
        $ahs_details = AHSDetails::all();
        $response = $this->generateCollection($ahs_details);
        return $this->sendResponse($response,200);
    }

    public function update(Request $request, $id)
    {
        $this->validateWith([
            'coefficient' => 'required|max:255',
            'sub_total' => 'required|max:255',
        ]);

        $detail = AHSDetails::findOrFail($id);
        $ahs = AHS::where('id_ahs',$detail->id_ahs)->first();

        $ahs->total = $ahs->total - $detail->sub_total;
        $ahs->save();

        $detail->coefficient = $request->coefficient;
        $detail->sub_total = $request->coefficient * $detail->sub_total;
        $detail->save();
        
        $ahs->total = $ahs->total + $detail->sub_total;
        $ahs->save();

        return response()->json([
            'status' => (bool) $detail,
            'data' => $detail,
            'message' => $detail ? 'Success' : 'Error Detail'
        ]);
    }

    public function destroy($id)
    {
        
        $detail = AHSDetails::findOrFail($id);
        $id_ahs = $detail->id_ahs;

        $ahs = AHS::findOrFail($id_ahs);
        $ahs->total -= $detail->sub_total;
        $ahs->save();
        $status = $detail->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Success' : 'Error Delete'
        ]);
    }

    public function showbyID($id)
    {
        $detail = AHSDetails::findOrFail($id);
        return response()->json($detail,200);
    }
}

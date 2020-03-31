<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSDetailsTransformers;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;
use App\AHS; 
use App\Materials;

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
        ]);

        $detail = AHSDetails::findOrFail($id);
        $ahs = AHS::where('id_ahs',$detail->id_ahs)->first();
        $material = Materials::where('id_material',$detail->id_material)->first();
        if($material->status == "material")
            $ahs->total_material -= $detail->sub_total;
        else
            $ahs->total_labor -= $detail->sub_total;
        $ahs->total_before_overhead -= $detail->sub_total;
        $ahs->total = $ahs->total_before_overhead + ($ahs->total_before_overhead*$ahs->overhead/100);
        $ahs->save();

        $detail->coefficient = $request->coefficient;
        $detail->sub_total = $detail->coefficient * $material->price;
        $detail->save();
        
        if($material->status == "material")
            $ahs->total_material += $detail->sub_total;
        else
            $ahs->total_labor += $detail->sub_total;
        $ahs->total_before_overhead += $detail->sub_total;
        $ahs->total = $ahs->total_before_overhead + ($ahs->total_before_overhead*$ahs->overhead/100);
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
        $ahs = AHS::findOrFail($detail->id_ahs);

        $material = Materials::where('id_material',$detail->id_material)->first();
        if($material->status == "material")
            $ahs->total_material -= $detail->sub_total;
        else
            $ahs->total_labor -= $detail->sub_total;
        $ahs->total_before_overhead -= $detail->sub_total;
        $ahs->total = $ahs->total_before_overhead + ($ahs->total_before_overhead * $ahs->overhead/100);
        $ahs->save();
        $status = $detail->delete();

        $ahs = AHSDetails::where('id_ahs',$detail->id_ahs)->get();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function showbyID($id)
    {
        $ahs = AHSDetails::where('id_ahs',$id)->get();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }
}

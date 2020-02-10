<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSAdjustDetailsTransformers;
use App\AHSAdjustDetails;
use App\AHSAdjust;
use App\Materials;

class AHSAdjustDetailsController extends RestController
{
    protected $transformer = AHSAdjustDetailsTransformers::Class;

    public function index()
    {
        $ahs_details_adjust = AHSAdjustDetails::all();
        $response = $this->generateCollection($ahs_details_adjust);
        return $this->sendResponse($response,200);
    }

    public function update(Request $request, $id)
    {
        $this->validateWith([
            'sub_adjustment' => 'required|max:255',
        ]);

        $detail = AHSAdjustDetails::findOrFail($id);
        // dd($detail);
        $ahs = AHSAdjust::where('id_ahs_adjust',$detail->id_ahs_adjust)->first();
        // dd($ahs);
        $material = Materials::where('id_material',$detail->id_material)->first();
        // dd($material);
        if($material->status == "material")
            $ahs->total_material -= $detail->sub_total;
        else
            $ahs->total_labor -= $detail->sub_total;

        $ahs->total = $ahs->total - $detail->sub_total;
        $ahs->save();

        $detail->sub_adjustment = $request->sub_adjustment;
        $detail->sub_total = $request->sub_adjustment * $detail->price_ahs;
        $detail->save();
        
        $details = AHSAdjustDetails::where('id_ahs_adjust',$ahs->id_ahs_adjust)->get();
        $ahs->adjustment=0;
        $count=0;
        foreach($details as $detail)
        {
            $ahs->adjustment += $detail->sub_adjustment;
            $count++;
        }
        $ahs->adjustment = $ahs->adjustment/$count;
        if($material->status == "material")
            $ahs->total_material += $detail->sub_total;
        else
            $ahs->total_labor += $detail->sub_total;
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
        $detail = AHSAdjustDetails::findOrFail($id);
        $ahs = AHSAdjust::where('id_ahs_adjust',$detail->id_ahs_adjust)->first();
        $material = Materials::where('id_material',$detail->id_material)->first();
        if($material->status == "labor")
            $ahs->total_labor -= $detail->sub_total;
        else
            $ahs->total_material -= $detail->sub_total;
        
        $ahs->total -= $detail->sub_total;
        
        // $ahs->adjustment -= $detail->sub_adjustment;
        $status = $detail->delete();
        $details = AHSAdjustDetails::where('id_ahs_adjust',$ahs->id_ahs_adjust)->get();
        // dd($details);
        $count = count($details);
        $ahs->adjustment=0;
        foreach($details as $detail)
        {
            $ahs->adjustment += $detail->sub_adjustment;
        }
        // dd($ahs->adjustment);
        $ahs->adjustment = $ahs->adjustment/$count;
        $ahs->save();

        return response()->json([
            'status' => (bool) $status,
            'data' => $status,
            'msg' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function showByID($id)
    {
        $ahs_adjust = AHSAdjust::where('id_ahs_adjust',$id)->first();
        $details = AHSAdjustDetails::where('id_ahs_adjust',$ahs_adjust->id_ahs_adjust)->get();
        $response = $this->generateCollection($details);
        return $this->sendResponse($response,200);
    }
}

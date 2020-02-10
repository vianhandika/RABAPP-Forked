<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSAdjustTransformers;
use Illuminate\Support\Facades\DB;
use App\AHSAdjustDetails;
use App\AHSAdjust;

class AHSAdjustController extends RestController
{
    protected $transformer = AHSAdjustTransformers::Class;

    public function index()
    {
        $ahs_adjust = AHSAdjust::all();
        $response = $this->generateCollection($ahs_adjust);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        try{
            if($request->has('detail'))
            {
                $ahs_detail_adjust = $request->get('detail');
            }
            
            $ahs_adjust = new AHSAdjust;
            $ahs_adjust->id_project = $request->get('id_project');
            $ahs_adjust->id_job = $request->get('id_job');
            $ahs_adjust->id_sub = $request->get('id_sub');
            $ahs_adjust->kode = $request->get('kode');
            $ahs_adjust->adjustment = $request->get('adjustment');
            $ahs_adjust->total_labor = $request->get('total_labor');
            $ahs_adjust->total_material = $request->get('total_material');
            $ahs_adjust->total = $request->get('total');
            $ahs_adjust->save();
            
            if($request->has('detail'));
            {
                $ahs_adjust = DB::transaction(function () use ($ahs_adjust,$ahs_detail_adjust) {
                    $ahs_adjust->detail_ahs_adjust()->createMany($ahs_detail_adjust);   
                    return $ahs_adjust;
                });
            }
            $response = $this->generateItem($ahs_adjust);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        $ahs_detail_adjust = AHSAdjustDetails::where('id_ahs_adjust',$id)->get();
        foreach($ahs_detail_adjust as $detail)
        {
            if(AHSAdjustDetails::where('id_ahs_adjust',$id)->get() != null)
                $delete = AHSAdjustDetails::where('id_ahs_adjust',$id)->delete();
        }
        
        $ahs_detail_adjust = $request->get('detail');
    
        $ahs_adjust=AHSAdjust::findOrFail($id);
        
        $ahs_adjust->id_job = $request->get('id_job');
        $ahs_adjust->id_sub = $request->get('id_sub');
        $ahs_adjust->kode = $request->get('kode');
        $ahs_adjust->adjustment = $request->get('adjustment');
        $ahs_adjust->total_labor = $request->get('total_labor');
        $ahs_adjust->total_material = $request->get('total_material');
        $ahs_adjust->total = $request->get('total');

       //kalau update ini berarti data rab details juga keupdate dong anying la 
        $ahs_adjust->save();

        if($request->has('detail'));
        {
            $ahs_adjust = DB::transaction(function () use ($ahs_adjust,$ahs_detail_adjust) {
                $ahs_adjust->detail_ahs_adjust()->createMany($ahs_detail_adjust);   
                return $ahs_adjust;
            });
        }
    }

    public function destroy($id)
    {
        $details=AHSAdjustDetails::where('id_ahs_adjust',$id)->get();
        foreach($details as $detail)
        {
            if(AHSAdjustDetails::where('id_ahs_adjust',$id)->get() !== null)
            $delete = AHSAdjustDetails::where('id_ahs_adjust',$id)->delete();
        }

        $ahs_adjust=AHSAdjust::find($id);
        $status = $ahs_adjust->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function showbyID($id)
    {
        $ahs_adjust = AHSAdjust::findOrFail($id);
        return response()->json($ahs_adjust,200);
    }
}

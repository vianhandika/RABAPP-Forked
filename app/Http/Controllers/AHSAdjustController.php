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
}

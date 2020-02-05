<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSTransformers2;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;
use App\AHS;

class AHSController extends RestController
{
    protected $transformer = AHSTransformers2::Class;

    public function index()
    {
        $ahs = AHS::all();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        try{
            if($request->has('detail'))
            {
                $detail_ahs = $request->get('detail');
            }
            
            $ahs = new AHS;
            $ahs->kode = $request->get('kode');
            $ahs->id_job = $request->get('id_job');
            $ahs->id_sub = $request->get('id_sub');
            $ahs->total_labor = $request->get('total_labor');
            $ahs->total_material = $request->get('total_material');
            $ahs->total = $request->get('total');
            $ahs->save();
            
            if($request->has('detail'));
            {
                $ahs = DB::transaction(function () use ($ahs,$detail_ahs) {
                    $ahs->detail_ahs()->createMany($detail_ahs);   
                    return $ahs;
                });
            }
            $response = $this->generateItem($ahs);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        $detail_ahs = AHSDetails::where('id_ahs',$id)->get();
        foreach($detail_ahs as $detail)
        {
            if(AHSDetails::where('id_ahs',$id)->get() != null)
                $delete = AHSDetails::where('id_ahs',$id)->delete();
        }
        
        $detail_ahs = $request->get('detail');
    
        $ahs=AHS::findOrFail($id);
        $ahs->kode = $request->get('kode');
        $ahs->id_sub = $request->get('id_sub');
        $ahs->total_labor = $request->get('total_labor');
        $ahs->total_material = $request->get('total_material');
        $ahs->total = $request->get('total');
        $ahs->save();

        if($request->has('detail'));
        {
            $ahs = DB::transaction(function () use ($ahs,$detail_ahs) {
                $ahs->detail_ahs()->createMany($detail_ahs);   
                return $ahs;
            });
        }
    }

    public function destroy($id)
    {
        $details=AHSDetails::where('id_ahs',$id)->get();
        foreach($details as $detail)
        {
            if(AHSDetails::where('id_ahs',$id)->get() !== null)
            $delete = AHSDetails::where('id_ahs',$id)->delete();
        }

        $ahs=AHS::find($id);
        $status = $ahs->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function showbyID($id)
    {
        $ahs = AHS::findOrFail($id);
        return response()->json($ahs,200);
    }

    public function count_ahs()
    {
        $ahs = AHS::all();
        $count = count($ahs);

        $result['data'][0]['count']=$count;
        return $result;
    }
}

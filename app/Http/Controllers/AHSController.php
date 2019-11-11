<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSTransformers;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;
use App\AHS;

class AHSController extends RestController
{
    protected $transformer = AHSTransformers::Class;

    public function index()
    {
        $ahs = AHS::orderBy('id_ahs','DESC')->get();
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
            $ahs->kode      = $request->get('kode');
            $ahs->id_job    = $request->get('id_job');
            $ahs->total     = $request->get('total');
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
                $ahs->total = 0;
        }
        
        $detail_ahs = $request->get('detail');
    
        $ahs=AHS::findOrFail($id);
        $ahs->kode      = $request->get('kode');
        $ahs->id_job    = $request->get('id_job');
        $ahs->total     = $request->get('total');
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
}

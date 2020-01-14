<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RAB;
use App\RABDetails;
use App\Transformers\RABTransformers;
use Illuminate\Support\Facades\DB;

class RABController extends RestController
{
    protected $transformer = RABTransformers::Class;

    public function index()
    {
        $rab = RAB::all();
        $response = $this->generateCollection($rab);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        try{
            if($request->has('detail')){
                $detail_rab = $request->get('detail');
            }
            $rab = new RAB;
            $rab->id_project    = $request->get('id_project');
            $rab->id_ahs        = $request->get('id_ahs');
            $rab->kode          = $request->get('kode');
            $rab->sub           = $request->get('sub');
            $rab->total_rab     = $request->get('total_rab');
            $rab->desc          = $request->get('desc');

            $rab->save();

            if($request->has('detail'));
            {
                $rab = DB::transaction(function () use ($rab,$detail_rab) {
                    $rab->detail_rab()->createMany($detail_rab);   
                    return $rab;
                });
            }
            $response = $this->generateItem($rab);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        $rab=RAB::findOrFail($id);

        $detail_rab = RABDetails::where('id_rab',$id)->get();
        foreach($detail_rab as $detail)
        {
            if(RABDetails::where('id_rab',$id)->get() != null)
                $delete = RABDetails::where('id_rab',$id)->delete();
                $rab->total_rab = 0;
        }
        
        $detail_rab = $request->get('detail');
    
        $rab = RAB::findOrFail($id);
        $rab->id_project    = $request->get('id_project');
        $rab->id_ahs        = $request->get('id_ahs');
        $rab->kode          = $request->get('kode');
        $rab->sub           = $request->get('sub');
        $rab->total_rab     = $request->get('total_rab');
        $rab->desc          = $request->get('desc');


        $rab->save();

        if($request->has('detail'));
        {
            $rab = DB::transaction(function () use ($rab,$detail_rab) {
                $rab->detail_rab()->createMany($detail_rab);   
                return $rab;
            });
        }
    }

    public function destroy($id)
    {
        $details = RABDetails::where('id_rab',$id)->get();
        foreach($details as $detail)
        {   
            if(RABDetails::where('id_rab',$id)->get() != null)
                $delete = RABDetails::where('id_rab',$id)->delete();
        }

        $rab=RAB::find($id);
        $status = $rab->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function count()
    {
        $rab = RAB::all();
        $count = count($rab);

        $result['data'][0]['count']=$count;
        return $result;
    }

    public function total()
    {
        $rab = RAB::all();
        $total = $rab->sum('total_rab');
        
        $result['data'][0]['total']=$total;
        return $result;
    }
}

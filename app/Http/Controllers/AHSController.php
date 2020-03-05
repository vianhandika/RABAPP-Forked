<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSTransformers2;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;
use App\AHS;
use App\Transformers\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class AHSController extends RestController
{
    protected $transformer = AHSTransformers2::Class;

    public function index()
    {
        $ahsPaginator = AHS::orderBy('id_ahs','DESC')->paginate(3);
        $ahs = new Collection($ahsPaginator->items(), new AHSTransformers2);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        
        $ahs = $this->manager->createData($ahs); 
        
        return $ahs->toArray(); 
    }

    public function all()
    {
        $ahs = AHS::all();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response);
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
        $ahs=AHS::findOrFail($id);
        $Detail = AHSDetails::where('id_ahs',$id)->select('id_ahs_details','id_material','coefficient','sub_total')->get();
        $details=[];
        $detailTemp=[];

        if($request->has('detail'))
        {
            $detail = $request->get('detail');
        }

        foreach($detail as $detail_ahs)
        {
            if($detail_ahs['id_ahs_details'] == null)
            {
                array_push($details,$ahs->detail_ahs()->create($detail_ahs));
            }
            else
            {
                $detail_data = AHSDetails::find($detail_ahs['id_ahs_details']);
                $detail_data->id_material = $detail_ahs['id_material'];
                $detail_data->coefficient = $detail_ahs['coefficient'];
                $detail_data->sub_total = $detail_ahs['sub_total'];
                $detail_data->save();
            }
        }

        foreach($detail as $detail_ahs)
        {
            if($detail_ahs['id_ahs_details'] != null)
            {
                array_push($detailTemp,$detail_ahs);
            }
        }
        $collection = collect($detailTemp);
        $diff = $Detail->diffKeys($collection);
        $diff->all();
        
        foreach($diff as $diff_data)
        {
            if($diff->isNotEmpty())
                $delete = AHSDetails::where('id_ahs_details',$diff_data->id_ahs_details)->delete();
        }

        $ahs->total_labor = $request->total_labor; 
        $ahs->total_material = $request->total_material;
        $ahs->total = $request->total;
        $ahs->save();
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

    public function copy_ahs(Request $request)
    {
        try
        {
            $ahs = AHS::findOrFail($request->get('id_ahs'));
            $details = AHSDetails::where('id_ahs',$request->get('id_ahs'))->get()->toArray();

            $new = new AHS();
            $new->id_sub = $ahs->id_sub;
            $new->id_job = $ahs->id_job;
            $new->kode = 'CPY'. '-'. $ahs->kode; 
            $new->total_labor = $ahs->total_labor;
            $new->total_material = $ahs->total_material;
            $new->total = $ahs->total;
            $new->save();
            
            if($details != null)
            {
                $new = DB::transaction(function () use ($new,$details) {
                    $new->detail_ahs()->createMany($details);
                    return $new;
                });
            }
            $response = $this->generateItem($new);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }
}

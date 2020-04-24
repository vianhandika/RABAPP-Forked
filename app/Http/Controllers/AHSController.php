<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSTransformers2;
use Illuminate\Support\Facades\DB;
use App\AHSDetails;
use App\AHS;
use App\Job;
use App\TaskSub;
use App\Transformers\IlluminatePaginatorAdapter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AHSController extends RestController
{
    protected $transformer = AHSTransformers2::Class;

    public function index()
    {
        $ahsPaginator = AHS::orderBy('id_ahs','DESC')->paginate(5);
        $ahs = $this->generateCollection($ahsPaginator);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        $ahs = $this->manager->createData($ahs); 
        return $ahs->toArray();
    }
    
    public function filter(Request $request)
    {
        $ahsPaginator = AHS::where('id_job',$id)->paginate(5);
        $ahs = $this->generateCollection($ahsPaginator);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        $ahs = $this->manager->createData($ahs);
        return $ahs->toArray();
    }

    public function search($search)
    {
        $job = Job::where('name','LIKE',"%{$search}%")->get();
        $array=[];
        foreach($job as $item)
        {
            $ahs = AHS::where('id_job',$item->id_job)->get();
            foreach($ahs as $item)
            {
                array_push($array,$item);
            }
        }
        $sub = TaskSub::where('name','LIKE',"%{$search}%")->get();
        foreach($sub as $item)
        {
            $ahs = AHS::where('id_sub',$item->id_sub)->get();
            foreach($ahs as $item)
            {
                array_push($array,$item);
            }
        }
        $ahsPaginator = $this->paginate($array);
        $ahs = $this->generateCollection($ahsPaginator);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        $ahs = $this->manager->createData($ahs); 
        return $ahs->toArray();
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = new Collection($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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
            $ahs->overhead = $request->get('overhead');
            $ahs->total_labor = $request->get('total_labor');
            $ahs->total_material = $request->get('total_material');
            $ahs->total_equipment = $request->get('total_equipment');
            $ahs->total_before_overhead = $request->get('total_before_overhead');
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
        $details=[];
        $detailTemp=[];

        if($request->has('detail'))
        {
            $detail = $request->get('detail');
        }
        //Edit Delete AHS Details
        foreach($detail as $detail_ahs)
        {
            if($detail_ahs['id_ahs_details'] != null)
                array_push($detailTemp,$detail_ahs);
        }
        $Detail = AHSDetails::where('id_ahs',$id)->select('id_ahs_details','id_material','coefficient','sub_total')->get();
        $collection = collect($detailTemp);
        if($collection->isNotEmpty())
        {
            foreach($collection as $item)
            {
                $filtered = $Detail->filter(function ($value, $key) use ($item){
                    return $value->id_ahs_details != $item['id_ahs_details'];
                });
                $Detail = $filtered;
            }
        }else{
            $filtered = $Detail;
        }
        $filtered->all();
        // dd($filtered); 
        foreach($filtered as $filtered_data)
        {
            if($filtered->isNotEmpty())
                $delete = AHSDetails::where('id_ahs_details',$filtered_data->id_ahs_details)->delete();
        }
        //Edit AHS Details
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
        $ahs->id_sub = $request->id_sub;
        $ahs->id_job = $request->id_job;
        $ahs->total_labor = $request->total_labor; 
        $ahs->total_material = $request->total_material;
        $ahs->total_equipment = $request->total_equipment;
        $ahs->total_before_overhead = $request->total_before_overhead;
        $ahs->overhead = $request->overhead;
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
        $response = $this->generateItem($ahs);
        return $this->sendResponse($response);
    }

    public function show_detailsNotNull()
    {
        $ahsPaginator = AHS::has('detail_ahs')->orderBy('id_ahs','DESC')->paginate(5);
        $ahs = $this->generateCollection($ahsPaginator);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        $ahs = $this->manager->createData($ahs)->toArray();
        return $ahs;
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
            $kode = $this->code();
            $new->kode = $kode; 
            $new->total_labor = $ahs->total_labor;
            $new->total_material = $ahs->total_material;
            $new->total_equipment = $ahs->total_equipment;
            $new->total_before_overhead = $ahs->total_before_overhead;
            $new->overhead = $ahs->overhead;
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

    public function code()
    {
        $job = AHS::all()->last();
        if($job != null)
        {
            $strlen = strlen($job->kode);
            if($strlen == "12")
                $parts = explode('CPY-AHS-',$job->kode);
            else    
                $parts = explode('-',$job->kode);
        }
        if($job==null){
            $kode = 'AHS'.'-'.'0001';
        }
        else if(($parts[1]+1)<10) {
            $kode = 'AHS'.'-'.'000'.($parts[1]+1);
        }else if(($parts[1]+1)>=10 && ($parts[1]+1)<99){
            $kode = 'AHS'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=99 && ($parts[1]+1)<999){
            $kode = 'AHS'.'-'.'0'.($parts[1]+1);
        }else if(($parts[1]+1)==1000){
            $kode = 'AHS'.'-'.($parts[1]+1);
        }else{
            $kode = 'AHS'.'-'.'001';
        }
        return $kode;
    }
}

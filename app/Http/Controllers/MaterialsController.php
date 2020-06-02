<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materials;
use App\AHSDetails;
use App\AHS;
use App\Transformers\MaterialsTransformers;

class MaterialsController extends RestController
{
    protected $transformer=MaterialsTransformers::Class;

    public function index()
    {
        $material = Materials::orderBy('id_material','DESC')->get();
        $response = $this->generateCollection($material);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $material = Materials::create([
            'kode' => $request->kode,
            'id_store' => $request->id_store,
            'name' => $request->name,
            'type' => $request->type,
            'id_satuan' => $request->satuan,
            'spesification' => $request->spesification,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => (bool) $material,
            'data' => $material,
            'message' => $material ? 'Success' : 'Error Material'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateWith([
            'kode' => 'required|max:255',
            'id_store' => 'required|max:255',
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'price' => 'required|max:255',
            'spesification' => 'required|max:255',
            'status' => 'required|max:255',
            'satuan' => 'required|max:255',
        ]);

        $material = Materials::findOrFail($id);
        $details = AHSDetails::where('id_material',$material->id_material)->get();

        foreach($details as $detail)
        {
            if($details->isNotEmpty())
            {
                $ahs = AHS::where('id_ahs',$detail->id_ahs)->get();

                if($material->status != $request->status)
                {
                    foreach($ahs as $ahs_data)
                    {
                        if($request->status == "labor"){
                            $ahs_data->total_material -= $detail->sub_total;
                            $ahs_data->total_labor += $detail->sub_total;
                        }else{
                            $ahs_data->total_labor -= $detail->sub_total;
                            $ahs_data->total_material += $detail->sub_total;
                        }
                        $ahs_data->save();
                    }
                }
            }
        }
        $material->status = $request->status;
        $material->save();
        
        foreach($details as $detail)
        {
            if($details->isNotEmpty())
            {
                $ahs = AHS::where('id_ahs',$detail->id_ahs)->get();

                if($material->price != $request->price)
                {
                    foreach($ahs as $ahs_data)
                    {
                        if($request->status == "labor"){
                            $ahs_data->total_labor -= $detail->sub_total;
                        }else{
                            $ahs_data->total_material -= $detail->sub_total;
                        }
                        $ahs_data->total_before_overhead -= $detail->sub_total;
                        $ahs_data->total = $ahs_data->total_before_overhead + ($ahs_data->overhead * $ahs_data->total_before_overhead/100);
                        $ahs_data->save();

                        $detail->sub_total = $detail->coefficient * $request->price;
                        $detail->save();
                        
                        if($material->status == "labor")
                            $ahs_data->total_labor += $detail->sub_total;
                        else
                            $ahs_data->total_material += $detail->sub_total;
                        $ahs_data->total_before_overhead += $detail->sub_total;
                        $ahs_data->total = $ahs_data->total_before_overhead + ($ahs_data->overhead * $ahs_data->total_before_overhead/100);
                        $ahs_data->save();
                    }
                }
            }
        }
        $material->kode = $request->kode;
        $material->id_store = $request->id_store;
        $material->name = $request->name;
        $material->type = $request->type;
        $material->spesification = $request->spesification;
        $material->id_satuan = $request->satuan;
        $material->price = $request->price;
        $material->save();

        return response()->json([
            'status' => (bool) $material,
            'data' => $material,
            'message' => $material ? 'Success' : 'Error Material'
        ]);
    }


    public function destroy($id)
    {
        $material = Materials::findOrFail($id);
        $details = AHSDetails::where('id_material',$id)->get();
        foreach($details as $detail)
        {
            if($details->isNotEmpty())
            {
                $ahs = AHS::where('id_ahs',$detail->id_ahs)->get();
                foreach($ahs as $ahs_data)
                {
                    if($material->status == "labor")
                        $ahs_data->total_labor -= $detail->sub_total;
                    else    
                        $ahs_data->total_material -= $detail->sub_total;
                    $ahs_data->total_before_overhead -= $detail->sub_total;
                    $ahs_data->total = $ahs_data->total_before_overhead+($ahs_data->overhead * ($ahs_data->total_before_overhead/100));
                    $ahs_data->save();

                    $status_detail = $detail->delete();
                }
            }
        }
        $status = $material->delete();
        
        return response()->json([
            'status' => $material,
            'message' => $material ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function code()
    {
        $job = Materials::all()->last();
        if($job != null)
            $parts = explode('-',$job->kode);
        if($job==null){
            $kode = 'M/L'.'-'.'0001';
        }
        else if(($parts[1]+1)<10) {
            $kode = 'M/L'.'-'.'000'.($parts[1]+1);
        }else if(($parts[1]+1)>=10 && ($parts[1]+1)<99){
            $kode = 'M/L'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=99 && ($parts[1]+1)<999){
            $kode = 'M/L'.'-'.'0'.($parts[1]+1);
        }else if(($parts[1]+1)==1000){
            $kode = 'M/L'.'-'.($parts[1]+1);
        }else{
            $kode = 'M/L'.'-'.'001';
        }
        return $kode;
    }
}

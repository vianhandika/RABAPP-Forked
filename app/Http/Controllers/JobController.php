<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\JobTransformers;
use App\Job;
use App\AHS;
use App\AHSDetails;

class JobController extends RestController
{
    protected $transformer=JobTransformers::Class;

    public function index()
    {
        $job = Job::orderBy('id_job','DESC')->get();
        $response = $this->generateCollection($job);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $job = Job::create([
            'kode' => $request->kode,
            'name' => $request->name, 
            'id_satuan' => $request->satuan, 
            'status' => $request->status, 
            'details' => $request->details, 
            'group' => $request->group,
        ]);

        return response()->json([
            'status' => (bool) $job,
            'data' => $job,
            'message' => $job ? 'Success' : 'Error Job'
        ]);
    }
    
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'kode' => 'required|max:255',
            'name' => 'required|max:255|',
            'satuan' => 'required|max:255',
            'status' => 'required|max:255',
            'details' => 'required|max:255',
        ]);
        
        $job = Job::findOrFail($id);
        $job->kode = $request->kode;
        $job->name = $request->name;
        $job->id_satuan = $request->satuan;
        $job->status = $request->status;
        $job->details = $request->details;
        $job->group = $request->group;

        $job->save();

        return response()->json([
            'status'=>(bool) $job,
            'data' => $job,
            'msg'=> $job ? 'Success' : 'Error Edit'
        ]);
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        $ahs = AHS::where('id_job',$id)->get();
        foreach($ahs as $ahs_data)
        {
            $ahs_details = AHSDetails::where('id_ahs',$ahs_data->id_ahs)->get();
            foreach($ahs_details as $detail)
            {
                $delete = $detail->delete();
            }
            $ahs_data->delete();
        }
        $status = $job->delete();

        return response()->json([
            'status'=> $status,
            'message'=> $status ? 'Success' : 'Error Delete'
        ]);
    }

    public function code()
    {
        $job = Job::all()->last();
        if($job != null)
            $parts = explode('-',$job->kode);
        if($job==null){
            $kode = 'Pek'.'-'.'0001';
        }
        else if(($parts[1]+1)<10) {
            $kode = 'Pek'.'-'.'000'.($parts[1]+1);
        }else if(($parts[1]+1)>=10 && ($parts[1]+1)<=99){
            $kode = 'Pek'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=100 && ($parts[1]+1)<=999){
            $kode = 'Pek'.'-'.'0'.($parts[1]+1);
        }else{
            $kode = 'Pek'.'-'.($parts[1]+1);
        }
        return $kode;
    }
}

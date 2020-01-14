<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RABDetails;
use App\Transformers\RABDetailsTransformers;
use App\RAB;
use App\AHS;
use App\Job;

class RABDetailsController extends RestController
{
    protected $transformer = RABDetailsTransformers::Class;

    public function index()
    {
        $rab_details = RABDetails::all();
        $response = $this->generateCollection($rab_details);
        return $this->sendResponse($response,200);
    }

    public function update(Request $request,$id)
    {
        $this->validateWith([
            'coefficient' => 'required|max:255',
            'volume'    => 'required|max:255',
        ]);

        $rab_details = RABDetails::findOrFail($id);
        $rab = RAB::where('id_rab',$rab_details->id_rab)->first();
        $ahs = AHS::where('id_ahs',$rab_details->id_ahs)->first();
        $job = Job::where('id_job',$ahs->id_job)->first();

        $rab_details->coefficient = $request->coefficient;

        if($job->status == 'Price')
        {
            $rab->total_rab -= $rab_details->sub_total;
            $rab->save();

            $rab_details->sub_total = $ahs->total * $request->coefficient;
            $rab_details->volume = $request->volume;
            
            $rab->total_rab += $rab_details->sub_total;
            $rab->save();
        }else{
            $rab_details->volume = $request->coefficient * $request->volume;
        }
        $rab_details->save();

        return response()->json([
            'status' => (bool) $rab_details,
            'data' => $rab_details,
            'message' => $rab_details ? 'Success' : 'Error Detail'
        ]);
    }

    public function destroy($id)
    {
        $rab_details = RABDetails::findOrFail($id);
        $rab = RAB::where('id_rab',$rab_details->id_rab)->first();
        $rab->total_rab -= $rab_details->sub_total;
        $rab->save();

        $status = $rab_details->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Success' : 'Error Delete'
        ]);
    }
}

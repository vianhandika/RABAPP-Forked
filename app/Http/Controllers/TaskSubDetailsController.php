<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\TaskSubDetailsTransformers;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\RAB;

class TaskSubDetailsController extends RestController
{
    protected $transformer = TaskSubDetailsTransformers::Class;

    public function index()
    {
        $details = TaskSubDetails::all();
        $response = $this->generateCollection($details);
        return $this->sendResponse($response,200);
    }

    public function destroy($id)
    {
        $total = 0;
        $tasksub = TaskSubDetails::findOrFail($id);
        $details = RABDetails::where('id_sub_details',$tasksub->id_sub_details)->get();
        foreach($details as $detail)
        {   
            if(RABDetails::where('id_sub_details',$detail->id_sub_details)->get() != null)
            {
                $total += $detail->sub_total;
                $delete = RABDetails::where('id_sub_details',$detail->id_sub_details)->delete();
            }
        }
        // dd($total);
        $group = GroupDetails::where('id_group_details',$tasksub->id_group_details)->first();
        $structure = StructureDetails::where('id_structure_details',$group->id_structure_details)->first();
        // dd($structure->id_rab);
        $rab=RAB::findOrFail($structure->id_rab);
        $rab->total_rab = $rab->total_rab - $total;
        $rab->save();
        // dd($rab->total_rab);

        $status = $tasksub->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }
}

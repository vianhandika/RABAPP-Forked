<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\StructureDetailsTransformers;
use App\Structure;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\RAB;

class StructureDetailsController extends RestController
{
    protected $transformer = StructureDetailsTransformers::Class;

    public function index()
    {
        $details = StructureDetails::all();
        $response = $this->generateCollection($details);
        return $this->sendResponse($response,200);
    }

    public function destroy($id)
    {
        $total = 0;
        $structure = StructureDetails::findOrFail($id);
        $Groups = GroupDetails::where('id_structure_details',$structure->id_structure_details)->get();
        foreach($Groups as $group)
        {
            if(GroupDetails::where('id_structure_details',$structure->id_structure_details)->get() != null)
                $delete = GroupDetails::where('id_structure_details',$structure->id_structure_details)->delete();
            
                $TaskSub = TaskSubDetails::where('id_group_details',$group->id_group_details)->get();
                foreach($TaskSub as $tasksub)
                {
                    if(TaskSubDetails::where('id_group_details',$tasksub->id_group_details)->get()!= null)
                        $delete = TaskSubDetails::where('id_group_details',$tasksub->id_group_details)->delete();
                    
                    $details = RABDetails::where('id_sub_details',$tasksub->id_sub_details)->get();
                    foreach($details as $detail)
                    {   
                        if(RABDetails::where('id_sub_details',$detail->id_sub_details)->get() != null)
                        {
                            $total += $detail->sub_total;
                            $delete = RABDetails::where('id_sub_details',$detail->id_sub_details)->delete();
                        }
                    }
                }
            }
        
        $rab=RAB::findOrFail($structure->id_rab);
        $rab->total_rab = $rab->total_rab - $total;
        $rab->save();

        $status = $structure->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }
}

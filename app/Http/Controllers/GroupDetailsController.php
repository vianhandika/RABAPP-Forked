<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\GroupDetailsTransformers;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\AHSLokalDetails;
use App\RAB;
use App\Project;

class GroupDetailsController extends RestController
{
    protected $transformer = GroupDetailsTransformers::Class;

    public function index()
    {
        $details = GroupDetails::all();
        $response = $this->generateCollection($details);
        return $this->sendResponse($response,200);
    }

    public function destroy($id)
    {
        $total = 0;
        $group = GroupDetails::findOrFail($id);

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
                    $total += $detail->HP;
                    $delete = RABDetails::where('id_sub_details',$detail->id_sub_details)->delete();
                }

                $ahs = AHSLokalDetails::where('id_ahs_lokal',$detail->id_ahs_lokal)->get();
                foreach($ahs as $ahs_data)
                {
                    if(AHSLokalDetails::where('id_ahs_lokal',$ahs_data->id_ahs_lokal)->get() != null)
                        $delete = AHSLokalDetails::where('id_ahs_lokal',$ahs_data->id_ahs_lokal)->delete();
                }
            }
        }
        $structure = StructureDetails::where('id_structure_details',$group->id_structure_details)->first();
        $rab=RAB::findOrFail($structure->id_rab);
        $rab->total_rab = $rab->total_rab - $total;
        $rab->save();

        $project = Project::where('id_project',$rab->id_project)->first();
        $project->nominal = $rab->total_rab;
        $project->save();

        $status = $group->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function show($id)
    {
        $group = GroupDetails::where('id_structure_details',$id)->get();
        $response = $this->generateCollection($group);
        return $this->sendResponse($response,200);
    }
}

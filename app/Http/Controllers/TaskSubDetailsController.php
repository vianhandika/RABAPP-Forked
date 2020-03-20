<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\TaskSubDetailsTransformers;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\AHSLokalDetails;
use App\RAB;
use App\Project;

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
                $total += $detail->HP_Adjust;
                $delete = RABDetails::where('id_sub_details',$detail->id_sub_details)->delete();
            }
            
            $ahs = AHSLokalDetails::where('id_ahs_lokal',$detail->id_ahs_lokal)->get();
            foreach($ahs as $ahs_data)
            {
                if(AHSLokalDetails::where('id_ahs_lokal',$ahs_data->id_ahs_lokal)->get() != null)
                    $delete = AHSLokalDetails::where('id_ahs_lokal',$ahs_data->id_ahs_lokal)->delete();
            }
        }
        $group = GroupDetails::where('id_group_details',$tasksub->id_group_details)->first();
        $structure = StructureDetails::where('id_structure_details',$group->id_structure_details)->first();
        $rab=RAB::findOrFail($structure->id_rab);
        $rab->total_rab -= $total;
        $rab->save();

        $project = Project::where('id_project',$rab->id_project)->first();
        $project->nominal = $rab->total_rab;
        $project->save();

        $status = $tasksub->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function show($id)
    {
        $tasksub = TaskSubDetails::where('id_group_details',$id)->get();
        $response = $this->generateCollection($tasksub);
        return $this->sendResponse($response,200);
    }
}

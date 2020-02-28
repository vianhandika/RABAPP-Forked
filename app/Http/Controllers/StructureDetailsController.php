<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\StructureDetailsTransformers;
use App\Structure;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\AHSLokalDetails;
use App\RAB;
use App\Project;

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
            }
        
        $rab=RAB::findOrFail($structure->id_rab);
        $rab->total_rab = $rab->total_rab - $total;
        $rab->save();

        $project = Project::where('id_project',$rab->id_project)->first();
        $project->nominal = $rab->total_rab;
        $project->save();

        $status = $structure->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function show($id)
    {
        $structure = StructureDetails::where('id_rab',$id)->get();
        $response = $this->generateCollection($structure);
        return $this->sendResponse($response,200);
    }
}

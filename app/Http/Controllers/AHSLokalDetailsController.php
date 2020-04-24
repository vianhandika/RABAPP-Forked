<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSLokalDetailsTransformers;
use App\AHSLokalDetails;
use App\AHSLokal;
use App\RAB;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\Project;
use App\Materials;

class AHSLokalDetailsController extends RestController
{
    protected $transformer = AHSLokalDetailsTransformers::Class;

    public function index()
    {
        $ahs = AHSLokalDetails::all();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function showByID($id)
    {
        $ahs = AHSLokalDetails::where('id_ahs_lokal',$id)->get();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function destroy($id)
    {
        $detail = AHSLokalDetails::findOrfail($id);
        $ahs = RABDetails::findOrFail($detail->id_ahs_lokal);
        $material = Materials::findOrFail($detail->id_material);
        
        if($material->status == "labor")
            $ahs->total_labor -= $detail->sub_total;
        else
            $ahs->total_material -= $detail->sub_total;
        $ahs->HSP_before_overhead -= $detail->sub_total;
        $ahs->HSP = $ahs->HSP_before_overhead + ($ahs->HSP_before_overhead * $ahs->overhead/100);
        $ahs->save();

        $task = TaskSubDetails::findOrFail($ahs->id_sub_details);
        $group = GroupDetails::findOrFail($task->id_group_details);
        $structure = StructureDetails::findOrFail($group->id_structure_details);
        $rab = RAB::findOrFail($structure->id_rab);
        $rab->total_rab -= $ahs->HP_Adjust;
        $rab->save();

        $project = Project::findOrFail($rab->id_project);
        $project->nominal = $rab->total_rab;
        $project->save();

        $status = $detail->delete();

        return response()->json([
            'status' => $status,
            'msg' => $status ? 'Error' : 'Deleted'
        ]);
    }

    public function update(Request $request,$id)
    {
        $detail = AHSLokalDetails::findOrFail($id);
        $Detail = AHSLokalDetails::where('id_ahs_lokal',$detail->id_ahs_lokal)->get();

        $ahs = RABDetails::findOrFail($detail->id_ahs_lokal);
        $task = TaskSubDetails::findOrFail($ahs->id_sub_details);
        $group = GroupDetails::findOrFail($task->id_group_details);
        $structure = StructureDetails::findOrFail($group->id_structure_details);
        $rab = RAB::findOrFail($structure->id_rab);

        foreach($Detail as $detail_data)
        {
            if($detail_data != null)
            {
                $detail_data->adjustment = $request->adjustment;
                $detail_data->save();
            }
        }
        $rab->total_rab -= $ahs->HP_Adjust;
        $rab->save();

        $ahs->adjustment = $request->adjustment;
        $ahs->HP_Adjust = $ahs->HSP * $request->adjustment * $ahs->volume;
        $ahs->save(); 

        $rab->total_rab += $ahs->HP_Adjust;
        $rab->save();

        $project = Project::findOrFail($rab->id_project);
        $project->nominal = $rab->total_rab;
        $project->save();
    }
}

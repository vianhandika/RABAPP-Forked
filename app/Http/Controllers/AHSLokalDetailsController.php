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
        $ahs->total -= $detail->sub_total;
        $ahs->save();

        $task = TaskSubDetails::findOrFail($ahs->id_sub_details);
        $group = GroupDetails::findOrFail($task->id_group_details);
        $structure = StructureDetails::findOrFail($group->id_structure_details);
        $rab = RAB::findOrFail($structure->id_rab);
        $rab->total_rab -= $ahs->HP;
        $rab->save();

        $project = Project::findOrFail($rab->id_project);
        $project->nominal -= $rab->total_rab;
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
        $rab->total_rab -= $ahs->HP;
        $ahs->adjustment = $request->adjustment;
        $ahs->HP = $ahs->HSP * $request->adjustment * $ahs->volume;
        $ahs->save(); 

        $rab->total_rab += $ahs->HP;
        $rab->save();

        $project = Project::findOrFail($rab->id_project);
        $project->nominal = $rab->total_rab;
        $project->save();
    }

    // public function updateCoefficient(Request $request, $id)
    // {
    //     $detail = AHSLokalDetails::findOrFail($id);
    //     $material = Materials::findOrFail($detail->id_material);        
    //     $ahs = RABDetails::findOrFail($detail->id_ahs_lokal);
    //     $job = Job::findOrFail($ahs->id_job);
    //     $task = TaskSubDetails::findOrFail($ahs->id_sub_details);
    //     $group = GroupDetails::findOrFail($task->id_group_details);
    //     $structure = StructureDetails::findOrFail($group->id_structure_details);
    //     $rab = RAB::findOrFail($structure->id_rab);

    //     $detail->coefficient = $request->coefficient;

    //     if($job->status == "labor")
    //         $ahs->total_labor -= $detail->sub_total;
    //     else    
    //         $ahs->total_material -= $detail->sub_total;
    //     $ahs->HSP = $detail->sub_total;
    //     $rab->total_rab -= $ahs->HP;
    //     $detail->sub_total = $request->coefficient * $material->price;

    //     $ahs->save();
    //     $rab->save();
    //     $detail->save();

    //     if($task->status == "labor")
    //         $ahs->total_labor += $detail->sub_total;
    //     else
    //         $ahs->total_material += $detail->sub_total;
    //     $ahs->HP = $detail->sub_total * $rab->volume * $rab->adjustment;
    //     $ahs->save();

    //     $rab->total_rab += $ahs->HP;
    //     $rab->save();

    //     $project = Project::findOrFail($rab->id_project);
    //     $project->nominal = $rab->total_rab;
    //     $project->save();
    // }
}

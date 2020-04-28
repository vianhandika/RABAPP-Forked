<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\AHSLokalDetailsTransformers;
use App\Transformers\StructureDetailsTransformers;
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
    protected $structureTransformer = StructureDetailsTransformers::Class;

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

        $ahs->HP = $ahs->HSP * $ahs->volume;
        $ahs->HP_Adjust = $ahs->HP * $ahs->adjustment;
        $ahs->save();

        $rab->total_rab += $ahs->HP_Adjust;
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
        $ahs = RABDetails::findOrFail($detail->id_ahs_lokal);
        $task = TaskSubDetails::findOrFail($ahs->id_sub_details);
        $group = GroupDetails::findOrFail($task->id_group_details);
        $structure = StructureDetails::findOrFail($group->id_structure_details);
        $rab = RAB::findOrFail($structure->id_rab);

        $material = Materials::findOrFail($detail->id_material);

        $ahs->HSP_before_overhead -= $detail->sub_total;
        if($material->status == 'material')
            $ahs->total_material -= $detail->sub_total;
        else
            $ahs->total_labor -= $detail->sub_total;
        $ahs->save(); 

        $rab->total_rab -= $ahs->HP_Adjust;
        $rab->save();

        $detail->adjustment  = $request->adjustment;
        $detail->sub_total = $detail->coefficient * $material->price * $request->adjustment;
        $detail->save();
        
        $ahs->HSP_before_overhead += $detail->sub_total;
        $ahs->HSP = $ahs->HSP_before_overhead + ($ahs->HSP_before_overhead * $ahs->overhead/100);
        $ahs->HP = $ahs->HSP * $ahs->volume;
        $ahs->HP_Adjust =  $ahs->HP * $ahs->adjustment;
        if($material->status == 'material')
            $ahs->total_material += $detail->sub_total;
        else
            $ahs->total_labor += $detail->sub_total;
        $ahs->save();

        $rab->total_rab += $ahs->HP_Adjust;
        $rab->save();

        $project = Project::findOrFail($rab->id_project);
        $project->nominal = $rab->total_rab;
        $project->save();
    
        return response()->json([
            'detail' => $detail,
            'msg' => $detail ? 'Updated' : 'Error'
        ]);
    }

    public function updateadjAll(Request $request,$id)
    {
        if($request->has('detail'))
        {
            $detail = $request->get('detail');
        }
        
        foreach($detail as $item)
        {
            $detail_data = AHSLokalDetails::findOrFail($item['id_ahs_lokal_details']);
            $detail_data->id_material = $item['id_material'];
            $detail_data->kode = $item['kode'];
            $detail_data->coefficient = $item['coefficient'];
            $detail_data->sub_total = $item['sub_total'];
            $detail_data->adjustment = $item['adjustment'];
            $detail_data->save();

            $ahs = RABDetails::findOrFail($item['id_ahs_lokal']);
            $detail_all = AHSLokalDetails::where('id_ahs_lokal',$item['id_ahs_lokal'])->get();
            $temp_sub_total = 0;
            $total_material = 0;
            $total_labor = 0;
            foreach($detail_all as $item)
            {
                $material = Materials::findOrFail($item->id_material);
                if($material->status == 'material')
                    $total_material += $item->sub_total;
                else
                    $total_labor += $item->sub_total;
                $temp_sub_total += $item->sub_total;
            }
            $ahs->HSP_before_overhead = $temp_sub_total + $ahs->total_equipment;
            $ahs->total_material = $total_material;
            $ahs->total_labor = $total_labor;
            $ahs->HSP = $ahs->HSP_before_overhead + ($ahs->HSP_before_overhead * $ahs->overhead /100);
            $ahs->HP = $ahs->HSP * $ahs->volume;
            $ahs->HP_Adjust = $ahs->HP * $ahs->adjustment;
            $ahs->save();
        }

        $rab = RAB::findOrFail($id);
        $structure = StructureDetails::where('id_rab',$rab->id_rab)->get();
        $total=0;
        if($structure != null)
        {
            foreach ($structure as $item) 
            {
                $group = GroupDetails::where('id_structure_details',$item->id_structure_details)->get(); 
                if($group != null)
                {
                    foreach($group as $item)
                    {
                        $tasksub = TaskSubDetails::where('id_group_details',$item->id_group_details)->get();
                        // dd($tasksub);
                        if($tasksub != null)
                        {
                            foreach($tasksub as $item)
                            {
                                $details = RABDetails::where('id_sub_details',$item->id_sub_details)->get();
                                // dd($details);
                                if($details != null)
                                {
                                    foreach($details as $item)
                                    {
                                        $total += $item->HP_Adjust;
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }
        $rab->total_rab = $total;
        $rab->save();
        dd($rab);
        return response()->json([
            'ahs' => $ahs,
            'rab' => $rab,
        ]);
    }
}

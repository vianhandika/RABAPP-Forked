<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satuan;
use App\Transformers\SatuanTransformers;

class SatuanController extends RestController
{
    protected $transformer=SatuanTransformers::Class;

    public function index()
    {
        $satuan = Satuan::orderBy('id_satuan','DESC')->get();
        $response = $this->generateCollection($satuan);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $satuan = Satuan::create([
            'name' => $request->name,
        ]);
    
        return response()->json([
            'status' => (bool) $satuan,
            'data'   => $satuan,
            'message' => $satuan ? 'Success' : 'Error Satuan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->name = $request->name;
        $satuan->save();
    }

    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);
        $status = $satuan->delete();
    } 

    // public function store(Request $request)
    // {
    //     try{
    //         $rab = new RAB;
    //         $rab->id_project    = $request->get('id_project');
    //         $rab->kode          = $request->get('kode');
    //         $rab->total_rab     = $request->get('total_rab');
    //         $rab->desc          = $request->get('desc');
    //         $rab->save();

    //         if($request->has('detail_structure'))
    //         {
    //             $Structure = $request->get('detail_structure');
    //         }
    //         if($request->has('detail_group'))
    //         {
    //             $Groups = $request->get('detail_group');
    //         }
    //         if($request->has('detail_task'))
    //         {
    //             $TaskSub = $request->get('detail_task');
    //         }
    //         if($request->has('detail'))
    //         {
    //             $detail = $request->get('detail');
    //         }
    //         if($request->has('detail_material'))
    //         {
    //             $Material = $request->get('detail_material');
    //         }
    //         if($request->has('detail_structure'));
    //         {
    //             $rab = DB::transaction(function () use ($rab,$Structure) {
    //                 $rab->structures()->createMany($Structure);   
    //                 return $rab;
    //             });
    //         }
    //         $structure_data = StructureDetails::where('id_rab',$rab->id_rab)->get();
    //         $group_data = [];
    //         $task_sub_data = [];
    //         $detail_data = [];
    //         $material_data = [];

    //         foreach($structure_data as $structure)
    //         {
    //             foreach($Groups as $group)
    //             {
    //                 if($structure->id_structure == $group['id_structure'])
    //                     array_push($group_data,$structure->groups()->create($group));
    //             }
    //         }
        
    //         foreach($group_data as $group)
    //         {
    //             foreach($TaskSub as $task)
    //             {
    //                 $structure = StructureDetails::findOrFail($group->id_structure_details);

    //                 if($structure->id_structure == $task['id_structure']) 
    //                 {
    //                     if($group->id_groups == $task['id_groups'])
    //                         array_push($task_sub_data,$group->task_subs()->create($task));
    //                 }
                    
    //             }
    //         }

    //         foreach($task_sub_data as $task)
    //         {
    //             foreach($detail as $detail_o)
    //             {
    //                 $group = GroupDetails::findOrFail($task->id_group_details);
    //                 $structure = StructureDetails::findOrFail($group->id_structure_details);
                    
    //                 if($structure->id_structure == $detail_o['id_structure'])
    //                 {
    //                     if($group->id_groups == $detail_o['id_groups']) 
    //                     {
    //                         if($task->id_sub == $detail_o['id_sub'])
    //                             array_push($detail_data,$task->detail_rab()->create($detail_o));
    //                     }
    //                 }
    //             }
    //         }

    //         foreach($detail_data as $detail_o)
    //         {
    //             foreach($Material as $material)
    //             {
    //                 $task = TaskSubDetails::findOrFail($detail_o->id_sub_details);
    //                 $group = GroupDetails::findOrFail($task->id_group_details);
    //                 $structure = StructureDetails::findOrFail($group->id_structure_details);
                    
    //                 $ahs = AHS::where([
    //                     'id_job' => $detail_o->id_job,
    //                     'id_sub' => $task->id_sub,
    //                 ])->get()->first();

    //                 if($structure->id_structure == $material['id_structure'])
    //                 {
    //                     if($group->id_groups == $material['id_groups']) 
    //                     {
    //                         if($task->id_sub == $material['id_sub'])
    //                         {
    //                             if($ahs->id_ahs == $material['id_ahs'])
    //                                 array_push($material_data,$detail_o->detail_ahs_lokal()->create($material));
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $project = Project::findOrFail($rab->id_project);
    //         $project->nominal = $rab->total_rab;
    //         $project->save();
            
    //         $response = $this->generateItem($rab);
    //         return $this->sendResponse($response,201);
    //     }catch(\Exception $e){
    //         return $this->sendIseResponse($e->getMessage());
    //     }
    // }
}

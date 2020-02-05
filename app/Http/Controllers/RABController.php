<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RAB;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\Transformers\RABTransformers;
use Illuminate\Support\Facades\DB;

class RABController extends RestController
{
    protected $transformer = RABTransformers::Class;

    public function index()
    {
        $rab = RAB::all();
        $response = $this->generateCollection($rab);
        return $this->sendResponse($response,201);
    }

    public function store(Request $request)
    {
        try{
            if($request->has('detail')){
                $detail_rab = $request->get('detail');
            }
            $rab = new RAB;
            $rab->id_project    = $request->get('id_project');
            $rab->id_ahs        = $request->get('id_ahs');
            $rab->kode          = $request->get('kode');
            $rab->total_rab     = $request->get('total_rab');
            $rab->desc          = $request->get('desc');

            $rab->save();

            if($request->has('detail'));
            {
                $rab = DB::transaction(function () use ($rab,$detail_rab) {
                    $rab->detail_rab()->createMany($detail_rab);   
                    return $rab;
                });
            }
            $response = $this->generateItem($rab);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeN(Request $request)
    {
        try{
            if($request->has('detail_structure'))
            {
                $Structure = $request->get('detail_structure');
            }
            if($request->has('detail_group'))
            {
                $Groups = $request->get('detail_group');
            }
            if($request->has('detail_task'))
            {
                $TaskSub = $request->get('detail_task');
            }
            if($request->has('detail'))
            {
                $detail = $request->get('detail');
            }

            $rab = new RAB;
            $rab->id_project    = $request->get('id_project');
            $rab->kode          = $request->get('kode');
            $rab->total_rab     = $request->get('total_rab');
            $rab->desc          = $request->get('desc');

            $rab->save();

            if($request->has('detail_structure'));
            {
                $rab = DB::transaction(function () use ($rab,$Structure) {
                    $rab->structures()->createMany($Structure);   
                    return $rab;
                });
            }

            $structure_data = StructureDetails::where('id_rab',$rab->id_rab)->get();
            $group_data = [];
            $task_sub_data = [];
            $detail_data = [];

            foreach($structure_data as $structure)
            {
                foreach($Groups as $group)
                {
                    if($structure->id_structure == $group['id_structure'])
                        array_push($group_data,$structure->groups()->create($group));
                }
            }
        
            foreach($group_data as $group)
            {
                foreach($TaskSub as $task)
                {
                    $id = $group->id_group_details;
                    $data = GroupDetails::find($id)->structure;
                    $id_structure = $data['id_structure'];

                    if($id_structure == $task['id_structure']) 
                    {
                        if($group->id_groups == $task['id_groups'])
                            array_push($task_sub_data,$group->task_subs()->create($task));
                    }
                    
                }
            }

            foreach($task_sub_data as $task)
            {
                foreach($detail as $detail_o)
                {
                    $id = $task->id_sub_details;
                    $data = TaskSubDetails::find($id)->sub;
                    $id_group_details = $data['id_group_details'];
                    $id_groups = $data['id_groups'];
                    $data_n = GroupDetails::find($id_group_details)->structure;
                    $id_structure = $data_n['id_structure'];
                    
                    if($id_structure == $detail_o['id_structure'])
                    {
                        if($id_groups == $detail_o['id_groups']) 
                        {
                            if($task->id_sub == $detail_o['id_sub'])
                                array_push($detail_data,$task->detail_rab()->create($detail_o));
                        }
                    }
                }
            }
            $response = $this->generateItem($rab);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        $rab=RAB::findOrFail($id);

        $detail_rab = RABDetails::where('id_rab',$id)->get();
        foreach($detail_rab as $detail)
        {
            if(RABDetails::where('id_rab',$id)->get() != null)
                $delete = RABDetails::where('id_rab',$id)->delete();
                $rab->total_rab = 0;
        }
        
        $detail_rab = $request->get('detail');
    
        $rab = RAB::findOrFail($id);
        $rab->id_project    = $request->get('id_project');
        $rab->id_ahs        = $request->get('id_ahs');
        $rab->kode          = $request->get('kode');
        $rab->sub           = $request->get('sub');
        $rab->total_rab     = $request->get('total_rab');
        $rab->desc          = $request->get('desc');


        $rab->save();

        if($request->has('detail'));
        {
            $rab = DB::transaction(function () use ($rab,$detail_rab) {
                $rab->detail_rab()->createMany($detail_rab);   
                return $rab;
            });
        }
    }

    public function destroy($id)
    {
        $Structure = StructureDetails::where('id_rab',$id)->get();
        foreach($Structure as $structure)
        {
            if(StructureDetails::where('id_rab',$id)->get() != null)
            {
                $delete = StructureDetails::where('id_rab',$id)->delete();
            }
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
                                    $delete = RABDetails::where('id_sub_details',$detail->id_sub_details)->delete();
                            }
                    }
            }
        }
        
        $rab=RAB::find($id);
        $status = $rab->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function count()
    {
        $rab = RAB::all();
        $count = count($rab);

        $result['data'][0]['count']=$count;
        return $result;
    }

    public function total()
    {
        $rab = RAB::all();
        $total = $rab->sum('total_rab');
        
        $result['data'][0]['total']=$total;
        return $result;
    }
}

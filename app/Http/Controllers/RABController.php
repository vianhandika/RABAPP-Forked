<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RAB;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\Project;
use App\AHSLokalDetails;
use App\AHS;
use App\Transformers\RABTransformers;
use App\Transformers\GroupDetailsTransformers;
use Illuminate\Support\Facades\DB;
use App\Transformers\IlluminatePaginatorAdapter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RABController extends RestController
{
    protected $transformer = RABTransformers::Class;

    public function index()
    {
        $rab = RAB::all();
        $response = $this->generateCollection($rab);
        return $this->sendResponse($response);
    }

    public function getPagination()
    {
        $rabPaginator = RAB::orderBy('id_rab','DESC')->paginate(5);
        $rab = $this->generateCollection($rabPaginator);
        $rab->setPaginator(new IlluminatePaginatorAdapter($rabPaginator));
        $rab = $this->manager->createData($rab); 
        return $rab->toArray(); 
    }

    public function search($search)
    {
        $project = Project::where('name','LIKE',"%{$search}%")->get()->first();
        $rabPaginator = RAB::where('id_project',$project->id_project)->paginate(5);
        $rab = $this->generateCollection($rabPaginator);
        $rab->setPaginator(new IlluminatePaginatorAdapter($rabPaginator));
        $rab = $this->manager->createData($rab); 
        return $rab->toArray(); 
    }
    
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = new Collection($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function store(Request $request)
    {
        try{
            $rab = new RAB;
            $rab->id_project    = $request->get('id_project');
            $rab->kode          = $request->get('kode');
            $rab->total_rab     = $request->get('total_rab');
            $rab->desc          = $request->get('desc');
            $rab->save();

            $this->storeAll($rab,$request);

            $project = Project::findOrFail($rab->id_project);
            $project->nominal = $rab->total_rab;
            $project->save();
            
            $response = $this->generateItem($rab);
            return $this->sendResponse($response,201);
        }catch(\Exception $e){
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function copy(Request $request)
    {
        $new = new RAB;
        $rab = RAB::findOrFail($request->get('id_rab'));
        $new->id_project    = $rab->id_project;
        $new->kode          = $this->code();
        $new->total_rab     = $rab->total_rab;
        $new->desc          = $rab->desc;
        $new->save();

        $this->storeAll($new,$request);
    }
    
    public function storeAll($rab,$request)
    {
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
        if($request->has('detail_material'))
        {
            $Material = $request->get('detail_material');
        }
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
        $material_data = [];

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
                $structure = StructureDetails::findOrFail($group->id_structure_details);

                if($structure->id_structure == $task['id_structure']) 
                {
                    if($group->id_groups == $task['id_groups'])
                        array_push($task_sub_data,$group->task_subs()->create($task));
                }
                
            }
        }

        // foreach($task_sub_data as $task)
        // {
        //     foreach($detail as $detail_o)
        //     {
        //         $group = GroupDetails::findOrFail($task->id_group_details);
        //         $structure = StructureDetails::findOrFail($group->id_structure_details);
                
        //         if($structure->id_structure == $detail_o['id_structure'])
        //         {
        //             if($group->id_groups == $detail_o['id_groups']) 
        //             {
        //                 if($task->id_sub == $detail_o['id_sub'])
        //                     array_push($detail_data,$task->detail_rab()->create($detail_o));
        //             }
        //         }
        //     }
        // }

        foreach($task_sub_data as $task)
        {
            foreach($detail as $detail_o)
            {
                $group = GroupDetails::findOrFail($task->id_group_details);
                $structure = StructureDetails::findOrFail($group->id_structure_details);
                
                if($structure->id_structure == $detail_o['id_structure'])
                {
                    if($group->id_groups == $detail_o['id_groups']) 
                    {
                        if($task->id_sub == $detail_o['id_sub'])
                        {
                            $ahs_lokal = $detail_o;
                            unset($ahs_lokal->detail);
                            $created= $task->detail_rab()->create($ahs_lokal);
                            array_push($detail_data,$created);
                            foreach($detail_o['detail'] as $material)
                            {
                                array_push($material_data,$created->detail_ahs_lokal()->create($material));
                            }
                        }

                    }
                }
            }
        }

        // foreach($detail_data as $detail_o)
        // {
        //     foreach($Material as $material)
        //     {
        //         $task = TaskSubDetails::findOrFail($detail_o->id_sub_details);
        //         $group = GroupDetails::findOrFail($task->id_group_details);
        //         $structure = StructureDetails::findOrFail($group->id_structure_details);
                
        //         $ahs = AHS::where([
        //             'id_job' => $detail_o->id_job,
        //             'id_sub' => $task->id_sub,
        //         ])->get()->first();

        //         if($structure->id_structure == $material['id_structure'])
        //         {
        //             if($group->id_groups == $material['id_groups']) 
        //             {
        //                 if($task->id_sub == $material['id_sub'])
        //                 {
        //                     if($ahs->id_ahs == $material['id_ahs'])
        //                         array_push($material_data,$detail_o->detail_ahs_lokal()->create($material));
        //                 }
        //             }
        //         }
        //     }
        // }
    }
    public function update(Request $request,$id)
    {
        $rab=RAB::findOrFail($id);
        $structure_new=[];
        $structure_temp=[];
        $group_new=[];
        $group_temp=[];
        $tasksub_new=[];
        $tasksub_temp=[];
        $detail_new=[];
        $detail_temp=[];
        $material_new=[];
        $material_temp=[];
        $deleted_details=[];
        
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
        if($request->has('detail_material'))
        {
            $Material = $request->get('detail_material');
        }
        if($request->has('deleted_details'))
        {
            $deleted_details = $request->get('deleted_details');
        }

        // Edit Delete Detail Structure
        foreach($Structure as $structure_data)
        {
            if($structure_data['id_structure_details'] != null) 
            {
                array_push($structure_temp,$structure_data);
            }
        }
        $Detail_Structure = StructureDetails::where('id_rab',$id)->select('id_structure_details','id_structure')->get();
        $collection = collect($structure_temp);
        if($collection->isNotEmpty())
        {
            foreach($collection as $item)
            {
                $filtered = $Detail_Structure->filter(function($value, $key) use ($item){ 
                    return $value->id_structure_details != $item['id_structure_details'];
                });
                $Detail_Structure = $filtered;
            }
        }else{
            $filtered = $Detail_Structure;
        }
        $filtered->all();
        foreach($filtered as $filtered_data)
        {
            if($filtered->isNotEmpty())
                $delete = StructureDetails::where('id_structure_details',$filtered_data->id_structure_details)->delete();
        }
        //Edit Detail Groups
        foreach($structure_temp as $structure_unit)
        {
            foreach($Groups as $group_data)
            {
                if($group_data['id_group_details'] != null)
                {
                    if($structure_unit['id_structure'] == $group_data['id_structure'])
                        array_push($group_temp,$group_data);   
                }
            }
            //Edit Delete Detail Group
            $Detail_Group = DB::table('group_details')
                ->select('id_group_details','structure_details.id_structure','id_groups')
                ->join('structure_details','structure_details.id_structure_details','=','group_details.id_structure_details')
                ->where('group_details.id_structure_details',$structure_unit['id_structure_details'])
                ->whereNull('group_details.deleted_at')
                ->get();
            $collection = collect($group_temp);
            if($collection->isNotEmpty())
            {
                foreach($collection as $item)
                {
                    $filtered = $Detail_Group->filter(function($value, $key) use ($item){
                        return $value->id_group_details != $item['id_group_details'];
                    });
                    $Detail_Group = $filtered;
                }
            }else{
                $filtered = $Detail_Group;
            }
            $filtered->all();
            foreach($filtered as $filtered_data)
            {
                if($filtered->isNotEmpty())
                    $delete = GroupDetails::where('id_group_details',$filtered_data->id_group_details)->delete();
            }
            //Edit Detail Task
            foreach($group_temp as $group_unit)
            {
                foreach($TaskSub as $task_sub_data)
                {
                    if($task_sub_data['id_sub_details'] != null)
                    {
                        if($group_unit['id_structure'] == $task_sub_data['id_structure'])
                        {
                            if($group_unit['id_groups'] == $task_sub_data['id_groups'])
                                array_push($tasksub_temp,$task_sub_data);
                        }
                    }
                }
                //Edit Delete Detail Task 
                $Detail_Task = DB::table('task_sub_details')
                            ->select('id_sub_details','structure_details.id_structure','group_details.id_groups','id_sub')
                            ->join('group_details','group_details.id_group_details','=','task_sub_details.id_group_details')
                            ->join('structure_details','structure_details.id_structure_details','=','group_details.id_structure_details')
                            ->where('task_sub_details.id_group_details','=',$group_unit['id_group_details'])
                            ->whereNull('task_sub_details.deleted_at')
                            ->get();
                $collection = collect($tasksub_temp);
                if($collection->isNotEmpty())
                {
                    foreach($collection as $item)
                    {
                        $filtered = $Detail_Task->filter(function($value,$key) use ($item){
                            return $value->id_sub_details != $item['id_sub_details'];
                        });
                        $Detail_Task = $filtered;
                    }
                }else{
                    $filtered = $Detail_Task;
                }
                $filtered->all();
                foreach($filtered as $filtered_data)
                {
                    if($filtered->isNotEmpty())
                        $delete = TaskSubDetails::where('id_sub_details',$filtered_data->id_sub_details)->delete();
                }
                // Edit AHS
                // foreach($tasksub_temp as $task_sub_unit)
                // {
                //     foreach($detail as $detail_data)
                //     {
                //         if($detail_data['id_ahs_lokal'] != null)
                //         {
                //             if($task_sub_unit['id_structure'] == $detail_data['id_structure'])
                //             {
                //                 if($task_sub_unit['id_groups'] == $detail_data['id_groups'])
                //                 {
                //                     if($task_sub_unit['id_sub'] == $detail_data['id_sub'])
                //                         array_push($detail_temp,$detail_data);
                //                 }
                //             }
                //         }
                //     }
                //     //Edit Delete Detail AHS
                //     $Detail_AHS = DB::table('ahs_lokals')
                //         ->select('id_ahs_lokal', 'structure_details.id_structure','group_details.id_groups',
                //                 'task_sub_details.id_sub', 'a_h_s_s.id_ahs','jobs.name',
                //                 'ahs_lokals.id_sub_details','ahs_lokals.id_job',
                //                 'ahs_lokals.total_labor','ahs_lokals.total_material', 'ahs_lokals.total_equipment',
                //                 'HSP_before_overhead','ahs_lokals.overhead','HSP',
                //                 'volume','adjustment','HP','HP_Adjust')
                //         ->join('task_sub_details','task_sub_details.id_sub_details','=','ahs_lokals.id_sub_details')
                //         ->join('group_details','task_sub_details.id_group_details','=','group_details.id_group_details')
                //         ->join('structure_details','group_details.id_structure_details','=','structure_details.id_structure_details')
                //         ->join('a_h_s_s','a_h_s_s.id_job','=','ahs_lokals.id_job')
                //         ->join('jobs','jobs.id_job','=','a_h_s_s.id_job')
                //         ->where([
                //             'a_h_s_s.id_sub' => $task_sub_unit['id_sub'],
                //             'ahs_lokals.id_sub_details' => $task_sub_unit['id_sub_details'],
                //         ])
                //         ->whereNull('ahs_lokals.deleted_at')
                //         ->whereNull('a_h_s_s.deleted_at')
                //         ->get();
                //     $collection = collect($detail_temp);
                //     if($collection->isNotEmpty())
                //     {
                //         foreach($collection as $item)
                //         {
                //             $filtered = $Detail_AHS->filter(function($value,$key) use ($item){
                //                 return $value->id_ahs_lokal != $item['id_ahs_lokal'];
                //             });
                //             $Detail_AHS = $filtered;
                //         }
                //     }else{
                //         $filtered = $Detail_AHS;
                //     }
                //     $filtered->all();
                //     foreach($filtered as $filtered_data)
                //     {
                //         if($filtered->isNotEmpty()){
                //             $delete = RABDetails::where('id_ahs_lokal',$filtered_data->id_ahs_lokal)->first();
                //             // return $delete;
                //             // optional($delete->detail_ahs_lokal())->delete();
                //             // $delete->delete();

                //         }
                //     }
                //     //Edit Delete Detail AHS Lokal (Material)
                //     // foreach($detail_temp as $detail_unit)
                //     // {
                //     //     foreach($Material as $material_data)
                //     //     {
                //     //         if($material_data['id_ahs_lokal_details'] != null)
                //     //         {
                //     //             if($detail_unit['id_structure'] == $material_data['id_structure'])
                //     //             {
                //     //                 if($detail_unit['id_groups'] == $material_data['id_groups'])
                //     //                 {
                //     //                     if($detail_unit['id_sub'] == $material_data['id_sub'])
                //     //                     {
                //     //                         if($detail_unit['id_ahs'] == $material_data['id_ahs'])
                //     //                             array_push($material_temp,$material_data);
                //     //                     }
                //     //                 }
                //     //             }
                //     //         }
                //     //     }
                //     //     $Detail_Material = DB::table('ahs_lokal_details')
                //     //         ->select('ahs_lokal_details.id_ahs_lokal_details','structure_details.id_structure',
                //     //                 'group_details.id_groups','task_sub_details.id_sub','a_h_s_s.id_ahs','jobs.id_job',
                //     //                 'ahs_lokal_details.id_material','ahs_lokal_details.kode',
                //     //                 'ahs_lokal_details.coefficient', 'ahs_lokal_details.sub_total','ahs_lokal_details.adjustment')
                //     //         ->join('ahs_lokals','ahs_lokals.id_ahs_lokal','=','ahs_lokal_details.id_ahs_lokal')
                //     //         ->join('task_sub_details','task_sub_details.id_sub_details','=','ahs_lokals.id_sub_details')
                //     //         ->join('group_details','task_sub_details.id_group_details','=','group_details.id_group_details')
                //     //         ->join('structure_details','group_details.id_structure_details','=','structure_details.id_structure_details')
                //     //         ->join('a_h_s_s','a_h_s_s.id_job','=','ahs_lokals.id_job')
                //     //         ->join('jobs','jobs.id_job','=','a_h_s_s.id_job')
                //     //         ->where([
                //     //             'a_h_s_s.id_sub' => $detail_unit['id_sub'],
                //     //             'ahs_lokal_details.id_ahs_lokal' => $detail_unit['id_ahs_lokal'],
                //     //         ])
                //     //         ->whereNull('ahs_lokal_details.deleted_at')
                //     //         ->whereNull('a_h_s_s.deleted_at')
                //     //         ->get();
                //     //     // dd($Detail_Material);
                //     //     $collection = collect($material_temp); 
                //     //     if($collection->isNotEmpty())
                //     //     {
                //     //         foreach($collection as $item)
                //     //         {
                //     //             $filtered = $Detail_Material->filter(function ($value,$key) use ($item){
                //     //                 return $value->id_ahs_lokal_details != $item['id_ahs_lokal_details'];
                //     //             });
                //     //             $Detail_Material = $filtered;
                //     //         }
                //     //     }else{
                //     //         $filtered = $Detail_Material;
                //     //     }
                //     //     foreach($filtered as $filtered)
                //     //     {
                //     //         // if($filtered->isNotEmpty())
                //     //         $delete = AHSLokalDetails::where('id_ahs_lokal_details',$filtered->id_ahs_lokal_details)->delete();
                //     //     }
                //     //     $material_temp=[];
                //     // }
                //     $detail_temp=[];
                // }
                $tasksub_temp=[];
            }
            $group_temp=[];
        }
        //Edit Structure
        foreach($Structure as $structure_data)
        {
            if($structure_data['id_structure_details'] == null)
            {
                array_push($structure_new,$rab->structures()->create($structure_data));
            }
            else{
                $structure = StructureDetails::findOrFail($structure_data['id_structure_details']);
                $structure->id_structure = $structure_data['id_structure'];
                $structure->save();
            }
        }
        //Edit Groups
        foreach($Structure as $structure_data)
        {
            foreach($Groups as $group_data)
            {
                $detail_structure = StructureDetails::where([
                    'id_rab' => $id,
                    'id_structure' => $structure_data['id_structure'],
                ])->get()->first();

                if($group_data['id_group_details'] == null)
                {
                    if($structure_data['id_structure'] == $group_data['id_structure'])
                        array_push($group_new,$detail_structure->groups()->create($group_data));
                }else{
                    $group = GroupDetails::findOrFail($group_data['id_group_details']);
                    $group->id_groups = $group_data['id_groups'];
                    $group->save();             
                }
            }
        }
        //Edit Task Sub
        foreach($Groups as $group_data)
        {
            foreach($TaskSub as $task_sub_data)
            {
                $detail_structure = StructureDetails::where([
                    'id_rab' => $id,
                    'id_structure' => $group_data['id_structure'],
                ])->get()->first();

                $detail_group = GroupDetails::where([
                    'id_structure_details' => $detail_structure->id_structure_details,
                    'id_groups' => $group_data['id_groups']
                ])->get()->first();

                if($task_sub_data['id_sub_details'] == null)
                {
                    if($group_data['id_structure'] == $task_sub_data['id_structure'])
                    {
                        if($group_data['id_groups'] == $task_sub_data['id_groups'])
                        {
                            array_push($tasksub_temp,$detail_group->task_subs()->create($task_sub_data));
                        }
                    }
                }else{
                    $tasksub = TaskSubDetails::findOrFail($task_sub_data['id_sub_details']);
                    $tasksub->id_sub = $task_sub_data['id_sub'];
                    $tasksub->save();
                }
            }
        }
        //Edit AHS Lokal
        // foreach($TaskSub as $task_sub_data)
        // {
        //     foreach($detail as $detail_data)
        //     {
        //         if($detail_data['id_ahs_lokal'] == null)
        //         {
        //             $detail_structure = StructureDetails::where([
        //                 'id_rab' => $id,
        //                 'id_structure' => $task_sub_data['id_structure'],
        //             ])->get()->first();

        //             $detail_group = GroupDetails::where([
        //                 'id_structure_details' => $detail_structure->id_structure_details,
        //                 'id_groups' => $task_sub_data['id_groups']
        //             ])->get()->first();

        //             $detail_task = TaskSubDetails::where([
        //                 'id_group_details' => $detail_group->id_group_details,
        //                 'id_sub' => $task_sub_data['id_sub']
        //             ])->get()->first();
                    
        //             if($detail_structure->id_structure == $detail_data['id_structure'])
        //             {
        //                 if($detail_group->id_groups == $detail_data['id_groups'])
        //                 {
        //                     if($detail_task->id_sub == $detail_data['id_sub'])
        //                     {                                
        //                         array_push($detail_new,$detail_task->detail_rab()->create($detail_data));
        //                     }
        //                 }
        //             }
        //         }else{
        //             $ahs = RABDetails::findOrFail($detail_data['id_ahs_lokal']);
        //             $ahs->id_job = $detail_data['id_job'];
        //             $ahs->total_labor = $detail_data['total_labor'];
        //             $ahs->total_material = $detail_data['total_material'];
        //             $ahs->total_equipment = $detail_data['total_equipment'];
        //             $ahs->HSP_before_overhead = $detail_data['HSP_before_overhead'];
        //             $ahs->overhead = $detail_data['overhead'];
        //             $ahs->HSP = $detail_data['HSP'];
        //             $ahs->volume = $detail_data['volume'];
        //             $ahs->adjustment = $detail_data['adjustment'];
        //             $ahs->HP = $detail_data['HP'];
        //             $ahs->HP_Adjust = $detail_data['HP_Adjust'];
        //             $ahs->save();
        //         }
        //     }
        // }
        if(!empty($deleted_details)){
            foreach($deleted_details as $details){
                $delete = RABDetails::where('id_ahs_lokal',$details['id_ahs_lokal'])->first();
                // return $delete;
                optional($delete->detail_ahs_lokal())->delete();
                $delete->delete();
            }
        }
        foreach($TaskSub as $task_sub_data)
        {
            foreach($detail as $detail_data)
            {
                if($detail_data['id_ahs_lokal'] == null) //kalau data baru
                {
                    $detail_structure = StructureDetails::where([
                        'id_rab' => $id,
                        'id_structure' => $task_sub_data['id_structure'],
                    ])->get()->first();

                    $detail_group = GroupDetails::where([
                        'id_structure_details' => $detail_structure->id_structure_details,
                        'id_groups' => $task_sub_data['id_groups']
                    ])->get()->first();

                    $detail_task = TaskSubDetails::where([
                        'id_group_details' => $detail_group->id_group_details,
                        'id_sub' => $task_sub_data['id_sub']
                    ])->get()->first();
                    
                    if($detail_structure->id_structure == $detail_data['id_structure'])
                    {
                        if($detail_group->id_groups == $detail_data['id_groups'])
                        {
                            if($detail_task->id_sub == $detail_data['id_sub'])
                            {                                
                                // array_push($detail_new,$detail_task->detail_rab()->create($detail_data));
                                
                                $ahs_lokal = $detail_data;
                                unset($ahs_lokal->detail);
                                $created= $detail_task->detail_rab()->create($ahs_lokal);
                                array_push($detail_new,$created);
                                foreach($detail_data['detail'] as $material)
                                {
                                    array_push($material_new,$created->detail_ahs_lokal()->create($material));
                                }
                            }
                        }
                    }
                }
                // if else($detail_Data['id_ahs_lokal'] != null)
                // {
                //     $detail_structure = StructureDetails::where([
                //         'id_rab' => $id,
                //         'id_structure' => $task_sub_data['id_structure'],
                //     ])->get()->first();

                //     $detail_group = GroupDetails::where([
                //         'id_structure_details' => $detail_structure->id_structure_details,
                //         'id_groups' => $task_sub_data['id_groups']
                //     ])->get()->first();

                //     $detail_task = TaskSubDetails::where([
                //         'id_group_details' => $detail_group->id_group_details,
                //         'id_sub' => $task_sub_data['id_sub']
                //     ])->get()->first();
                    
                //     if($detail_structure->id_structure == $detail_data['id_structure'])
                //     {
                //         if($detail_group->id_groups == $detail_data['id_groups'])
                //         {
                //             if($detail_task->id_sub == $detail_data['id_sub'])
                //             {                                
                //                 // array_push($detail_new,$detail_task->detail_rab()->create($detail_data));
                                
                //                 $ahs_lokal = $detail_data;
                //                 unset($ahs_lokal->detail);
                //                 $updated = RABDetails::findOrFail($detail_data['id_ahs_lokal'])->update($ahs_lokal->All());
                //                 array_push($detail_new,$created);
                //                 foreach($detail_data['detail'] as $material)
                //                 {
                //                     array_push($material_new,$created->detail_ahs_lokal()->create($material));
                //                 }
                //             }
                //         }
                //     }
                   

                // }
                else
                {
                    $ahs = RABDetails::findOrFail($detail_data['id_ahs_lokal']);
                    if($ahs->id_job != $detail_data['id_job'])
                    {
                        optional($ahs->detail_ahs_lokal())->delete();
                        foreach($detail_data['detail'] as $material)
                        {
                            array_push($material_new,$ahs->detail_ahs_lokal()->create($material));
                        }
                    }
                    $ahs->id_job = $detail_data['id_job'];
                    $ahs->total_labor = $detail_data['total_labor'];
                    $ahs->total_material = $detail_data['total_material'];
                    $ahs->total_equipment = $detail_data['total_equipment'];
                    $ahs->HSP_before_overhead = $detail_data['HSP_before_overhead'];
                    $ahs->overhead = $detail_data['overhead'];
                    $ahs->HSP = $detail_data['HSP'];
                    $ahs->volume = $detail_data['volume'];
                    $ahs->adjustment = $detail_data['adjustment'];
                    $ahs->HP = $detail_data['HP'];
                    $ahs->HP_Adjust = $detail_data['HP_Adjust'];
                    $ahs->keterangan = $detail_data['keterangan'];
                    $ahs->save();

                }
            }
        }
        //Edit AHS Lokal Details (Materials)
        // foreach($detail as $detail_data)
        // {
        //     foreach($Material as $material_data)
        //     {
        //         // dd($detail_data);
        //         if($material_data['id_ahs_lokal_details'] == null)
        //         {
        //             $detail_structure = StructureDetails::where([
        //                 'id_rab' => $id,
        //                 'id_structure' => $detail_data['id_structure'],
        //             ])->get()->first();

        //             $detail_group = GroupDetails::where([
        //                 'id_structure_details' => $detail_structure->id_structure_details,
        //                 'id_groups' => $detail_data['id_groups']
        //             ])->get()->first();

        //             $detail_task = TaskSubDetails::where([
        //                 'id_group_details' => $detail_group->id_group_details,
        //                 'id_sub' => $detail_data['id_sub']
        //             ])->get()->first();

        //             $detail_ahs = RABDetails::where([
        //                 'id_sub_details' => $detail_task->id_sub_details,
        //                 'id_job' => $detail_data['id_job']  
        //             ])->get()->first();
                    

        //             $ahs_unit = AHS::findOrFail($detail_data['id_ahs']);
        //             if($detail_structure->id_structure == $material_data['id_structure'])
        //             {
        //                 if($detail_group->id_groups == $material_data['id_groups'])
        //                 {
        //                     if($detail_task->id_sub == $material_data['id_sub'])
        //                     { 
        //                         if($ahs_unit->id_ahs == $material_data['id_ahs'])                               
        //                             array_push($material_new,$detail_ahs->detail_ahs_lokal()->create($material_data));
        //                     }
        //                 }
        //             }
        //         }else{
        //             $ahs_lokal = AHSLokalDetails::findOrFail($material_data['id_ahs_lokal_details']);
        //             $ahs_lokal->id_material = $material_data['id_material'];
        //             $ahs_lokal->kode = $material_data['kode'];
        //             $ahs_lokal->coefficient = $material_data['coefficient'];
        //             $ahs_lokal->sub_total = $material_data['sub_total'];
        //             $ahs_lokal->adjustment = $material_data['adjustment'];
        //             $ahs_lokal->save();
        //         }
        //     }
        // } 
        $rab->id_project = $request->id_project;  
        $rab->desc = $request->desc;
        $rab->total_rab = $request->total_rab;
        $rab->save();
        
        $project = Project::findOrFail($rab->id_project);
        $project->nominal = $rab->total_rab;
        $project->save();
    }

    public function destroyAllDetail($id)
    {
        $Structure = StructureDetails::where('id_rab',$id)->get();
        if(StructureDetails::where('id_rab',$id)->get() != null)
        {
            foreach($Structure as $structure)
            {
                if(StructureDetails::where('id_rab',$id)->get() != null)
                    $delete = StructureDetails::where('id_rab',$id)->delete();

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
                            
                            $materials = AHSLokalDetails::where('id_ahs_lokal',$detail->id_ahs_lokal)->get();
                            foreach($materials as $material)
                            {   
                                if(AHSLokalDetails::where('id_ahs_lokal',$material->id_ahs_lokal)->get() != null)
                                    $delete = AHSLokalDetails::where('id_ahs_lokal',$material->id_ahs_lokal)->delete();
                            }
                        }
                    }
                }
            }
        }
    }

    public function destroy($id)
    {
        $this->destroyAllDetail($id);
        $rab=RAB::findOrFail($id);
        $project = Project::where('id_project',$rab->id_project)->first();
        $project->nominal = 0;
        $project->save();

        $status = $rab->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function code()
    {
        $job = RAB::all()->last();
        if($job != null)
            $parts = explode('-',$job->kode);
        if($job==null){
            $kode = 'RAB'.'-'.'0001';
        }
        else if(($parts[1]+1)<10) {
            $kode = 'RAB'.'-'.'000'.($parts[1]+1);
        }else if(($partsTj[1]+1)>=10 && ($parts[1]+1)<=99){
            $kode = 'RAB'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=100 && ($parts[1]+1)<=999){
            $kode = 'RAB'.'-'.'0'.($parts[1]+1);
        }else{
            $kode = 'RAB'.'-'.($parts[1]+1);
        }
        return $kode;
    }
}

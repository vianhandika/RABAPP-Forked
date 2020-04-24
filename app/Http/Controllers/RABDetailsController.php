<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\AHSLokalDetails;
use App\Transformers\RABDetailsTransformers;
use App\RAB;
use App\AHS;
use App\Job;
use App\Project;
use App\TaskSub;
use App\Transformers\IlluminatePaginatorAdapter;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RABDetailsController extends RestController
{
    protected $transformer = RABDetailsTransformers::Class;

    public function index()
    {
        $detailsPaginator = RABDetails::orderBy('id_ahs_lokal','DESC')->paginate(5);
        $details = $this->generateCollection($detailsPaginator);
        $details->setPaginator(new IlluminatePaginatorAdapter($detailsPaginator));

        $details = $this->manager->createData($details);

        return $details->toArray();
    }

    public function search($search)
    {
        $job = Job::where('name','LIKE',"%{$search}%")->get();
        $project = Project::where('name','LIKE',"%{$search}%")->get();
        $tasksub = TaskSub::where('name','LIKE',"%{$search}%")->get();

        $array=[];
        foreach($job as $item)
        {
            $ahs = RABDetails::where('id_job',$item->id_job)->get();
            foreach($ahs as $item)
            {
                array_push($array,$item);
            }
        }
        foreach($project as $item)
        {
            $rab = RAB::where('id_project',$item->id_project)->get();
            foreach($rab as $item)
            {
                $structure = StructureDetails::where('id_rab',$item->id_rab)->get();
                foreach($structure as $item)
                {
                    $group = GroupDetails::where('id_structure_details',$item->id_structure_details)->get();
                    foreach($group as $item)
                    {
                        $task = TaskSubDetails::where('id_group_details',$item->id_group_details)->get();
                        foreach($task as $item)
                        {
                            $ahs = RABDetails::where('id_sub_details',$item->id_sub_details)->get();
                            foreach($ahs as $item)
                            {
                                array_push($array,$item);
                            }
                        }
                    }
                }
            }
        }
        foreach($tasksub as $item)
        {
            $task = TaskSubDetails::where('id_sub',$item->id_sub)->get();
            foreach($task as $item)
            {
                $ahs = RABDetails::where('id_sub_details',$item->id_sub_details)->get();
                foreach($ahs as $item)
                {
                    array_push($array,$item);
                }
            }
        }
        $ahsPaginator = $this->paginate($array);
        $ahs = $this->generateCollection($ahsPaginator);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        $ahs = $this->manager->createData($ahs); 
        return $ahs->toArray();
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = new Collection($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function destroy($id)
    {
        $details = RABDetails::findOrFail($id);
        $tasksub = TaskSubDetails::where('id_sub_details',$details->id_sub_details)->first();
        $group = GroupDetails::where('id_group_details',$tasksub->id_group_details)->first();
        $structure = StructureDetails::where('id_structure_details',$group->id_structure_details)->first();

        $rab = RAB::where('id_rab',$structure->id_rab)->first();
        $rab->total_rab -= $details->HP_Adjust;
        $rab->save();

        $project = Project::where('id_project',$rab->id_project)->first();
        $project->nominal = $rab->total_rab;
        $project->save();

        $ahs = AHSLokalDetails::where('id_ahs_lokal',$details->id_ahs_lokal)->get();
        foreach($ahs as $ahs_data)
        {
            if(AHSLokalDetails::where('id_ahs_lokal',$ahs_data->id_ahs_lokal)->get() != null)
                $delete = AHSLokalDetails::where('id_ahs_lokal',$ahs_data->id_ahs_lokal)->delete();
        }

        $status = $details->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Success' : 'Error Delete'
        ]);
    }

    public function show_detailsNotNull()
    {
        $ahsPaginator = RABDetails::has('detail_ahs_lokal')->orderBy('id_ahs_lokal','DESC')->paginate(5);
        $ahs = $this->generateCollection($ahsPaginator);
        $ahs->setPaginator(new IlluminatePaginatorAdapter($ahsPaginator));
        $ahs = $this->manager->createData($ahs)->toArray();
        return $ahs;
    }

    public function showByID($id)
    {
        $ahs = RABDetails::where('id_sub_details',$id)->get();
        $response = $this->generateCollection($ahs);
        return $this->sendResponse($response,200);
    }

    public function show($id)
    {
        $rab_details = RABDetails::where('id_ahs_lokal',$id)->get();
        $response = $this->generateCollection($rab_details);
        return $this->sendResponse($response,200);
    }

    public function update(Request $request,$id)
    {
        // dd($request);
        $ahs=RABDetails::findOrFail($id);
        $details=[];
        $detailTemp=[];

        if($request->has('detail'))
        {
            $detail = $request->get('detail');
        }
        //Edit Delete AHS Lokal Details
        foreach($detail as $detail_ahs)
        {
            if($detail_ahs['id_ahs_lokal_details'] != null)
                array_push($detailTemp,$detail_ahs);
        }
        $Detail = AHSLokalDetails::where('id_ahs_lokal',$id)
                ->select('id_ahs_lokal_details','id_material','coefficient','sub_total','adjustment')->get();
        $collection = collect($detailTemp);
        if($collection->isNotEmpty())
        {
            foreach($collection as $item)
            {
                $filtered = $Detail->filter(function ($value, $key) use ($item){
                    return $value->id_ahs_lokal_details != $item['id_ahs_lokal_details'];
                });
                $Detail = $filtered;
            }
        }else{
            $filtered = $Detail;
        }
        $filtered->all();
        // dd($filtered); 
        foreach($filtered as $filtered_data)
        {
            if($filtered->isNotEmpty())
                $delete = AHSLokalDetails::where('id_ahs_lokal_details',$filtered_data->id_ahs_lokal_details)->delete();
        }
        //Edit AHS Lokal Details
        foreach($detail as $detail_ahs)
        {
            if($detail_ahs['id_ahs_lokal_details'] == null)
            {
                array_push($details,$ahs->detail_ahs_lokal()->create($detail_ahs));
            }else{
                $detail_data = AHSLokalDetails::find($detail_ahs['id_ahs_lokal_details']);
                $detail_data->id_material = $detail_ahs['id_material'];
                $detail_data->coefficient = $detail_ahs['coefficient'];
                $detail_data->sub_total = $detail_ahs['sub_total'];
                $detail_data->adjustment = $detail_ahs['adjustment'];
                $detail_data->save();
            }
        }

        $ahs->id_sub_details = $request->id_sub_details;
        $ahs->id_job = $request->id_job;
        $ahs->total_labor = $request->total_labor; 
        $ahs->total_material = $request->total_material;
        $ahs->total_equipment = $request->total_equipment;
        $ahs->HSP_before_overhead = $request->HSP_before_overhead;
        $ahs->overhead = $request->overhead;
        $ahs->HSP = $request->HSP;
        $ahs->volume = $request->volume;
        $ahs->adjustment = $request->adjustment;
        $ahs->HP = $request->HP;
        $ahs->HP_Adjust = $request->HP_Adjust;
        $ahs->save();
    }
}

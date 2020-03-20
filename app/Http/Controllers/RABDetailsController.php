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
use League\Fractal\Resource\Collection;
use App\Transformers\IlluminatePaginatorAdapter;

class RABDetailsController extends RestController
{
    protected $transformer = RABDetailsTransformers::Class;

    public function index()
    {
        $detailsPaginator = RABDetails::orderBy('id_ahs_lokal','DESC')->paginate(3);
        $details = new Collection($detailsPaginator->items(),new RABDetailsTransformers);
        $details->setPaginator(new IlluminatePaginatorAdapter($detailsPaginator));

        $details = $this->manager->createData($details);

        return $details->toArray();
    }

    // public function update(Request $request,$id)
    // {
    //     $this->validateWith([
    //         'coefficient' => 'required|max:255',
    //         'volume'    => 'required|max:255',
    //     ]);

    //     $rab_details = RABDetails::findOrFail($id);
    //     $rab = RAB::where('id_rab',$rab_details->id_rab)->first();
    //     $ahs = AHS::where('id_ahs',$rab_details->id_ahs)->first();
    //     $job = Job::where('id_job',$ahs->id_job)->first();

    //     $rab_details->coefficient = $request->coefficient;

    //     if($job->status == 'Price')
    //     {
    //         $rab->total_rab -= $rab_details->HP_Adjust;
    //         $rab->save();

    //         $rab_details->sub_total = $ahs->total * $request->coefficient;
    //         $rab_details->volume = $request->volume;
            
    //         $rab->total_rab += $rab_details->HP_Adjust;
    //         $rab->save();
    //     }else{
    //         $rab_details->volume = $request->coefficient * $request->volume;
    //     }
    //     $rab_details->save();

    //     return response()->json([
    //         'status' => (bool) $rab_details,
    //         'data' => $rab_details,
    //         'message' => $rab_details ? 'Success' : 'Error Detail'
    //     ]);
    // }

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

    public function show($id)
    {
        $rab_details = RABDetails::where('id_sub_details',$id)->get();
        $response = $this->generateCollection($rab_details);
        return $this->sendResponse($response,200);
    }
}

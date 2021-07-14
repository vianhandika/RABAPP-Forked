<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ProjectTransformers;
use App\Project;
use App\RAB;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\AHSLokalDetails;
// use App\Http\Controllers\RABController;

class ProjectController extends RestController
{
    protected $transformer=ProjectTransformers::Class;

    public function index()
    {
        $project = Project::orderBy('id_project','DESC')->get();
        $response = $this->generateCollection($project);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $project = Project::create([
            'id_project' => $request->id_project,
            'kode' => $request->kode,
            'name' => $request->name,
            'address' => $request->address,
            'owner' => $request->owner,
            'date' => $request->date,
            'no_telp' => $request->no_telp,
            'phone' => $request->phone,
            'type' => $request->type,
            'nominal' => $request->nominal
        ]);

        return response()->json([
            'status'=> (bool)$project,
            'data'=>$project,
            'message'=>$project ? 'Success' : 'Error Project'
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'kode' => 'required|max:255',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'owner' => 'required|max:255',
            'date' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'phone' => 'required|max:255',
            'type' => 'required|max:255',
            'nominal' => 'required|max:255',
        ]);

        $project = Project::findOrFail($id);
        $project->kode      = $request->kode;
        $project->name      = $request->name;
        $project->address   = $request->address;
        $project->owner     = $request->owner;
        $project->date      = $request->date;
        $project->no_telp   = $request->no_telp;
        $project->phone     = $request->phone;
        $project->type      = $request->type;
        $project->nominal   = $request->nominal;

        $project->save();

        return response()->json([
            'status'=>(bool) $project,
            'data' => $project,
            'msg'=> $project ? 'Success' : 'Error Edit'
        ]);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        $rab = RAB::where('id_project',$project->id_project)->get()->first();
        // dd($rab);
        if($rab != null)
        {   
            $Structure = StructureDetails::where('id_rab',$rab->id_rab)->get();
            if(StructureDetails::where('id_rab',$rab->id_rab)->get() != null)
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
            $delete = $rab->delete();
        }
        $status = $project->delete();

        return response()->json([
            'status'=> $status,
            'message'=> $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function code()
    {
        $project = Project::all()->last();
        if($project != null)
            $parts = explode('-',$project->kode);
        if($project==null){
            $kode = 'Pr'.'-'.'0001';
        }
        else if(($parts[1]+1)<10) {
            $kode = 'Pr'.'-'.'000'.($parts[1]+1);
        }else if(($parts[1]+1)>=10 && ($parts[1]+1)<=99){
            $kode = 'Pr'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=100 && ($parts[1]+1)<=999){
            $kode = 'Pr'.'-'.'0'.($parts[1]+1);
        }else{
            $kode = 'Pr'.'-'.($parts[1]+1);
        }
        return $kode;
    }
}

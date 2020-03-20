<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ProjectTransformers;
use App\Project;

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

    public function showbyID($id)
    {
        $project = Project::find($id);
        return response()->json($project,200);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
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
        }else if(($parts[1]+1)>=10 && ($parts[1]+1)<99){
            $kode = 'Pr'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=99 && ($parts[1]+1)<999){
            $kode = 'Pr'.'-'.'0'.($parts[1]+1);
        }else if(($parts[1]+1)==1000){
            $kode = 'Pr'.'-'.($parts[1]+1);
        }else{
            $kode = 'Pr'.'-'.'001';
        }
        return $kode;
    }
}

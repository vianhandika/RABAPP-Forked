<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\JobTransformers;
use App\Job;

class JobController extends RestController
{
    protected $transformer=JobTransformers::Class;

    public function index()
    {
        $job = Job::all();
        $response = $this->generateCollection($job);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $job = Job::create([
            'kode' => $request->kode,
            'name' => $request->name, 
           'satuan' => $request->satuan, 
           'details' => $request->details, 
        ]);

        return response()->json([
            'status' => (bool) $job,
            'data' => $job,
            'message' => $job ? 'Success' : 'Error Job'
        ]);
    }
    
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'kode' => 'required|max:255',
            'name' => 'required|max:255',
            'satuan' => 'required|max:255',
            'details' => 'required|max:255',
        ]);

        $job = Job::findOrFail($id);
        $job->kode = $request->kode;
        $job->name = $request->name;
        $job->satuan = $request->satuan;
        $job->details = $request->details;
        $job->save();

        return response()->json([
            'status'=>(bool) $job,
            'data' => $job,
            'msg'=> $job ? 'Success' : 'Error Edit'
        ]);
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        $status = $job->delete();

        return response()->json([
            'status'=> $status,
            'message'=> $status ? 'Success' : 'Error Delete'
        ]);
    }

    public function showbyID($id)
    {
        $job = Job::findOrFail($id);
        return response()->json($job,200);
    }
}

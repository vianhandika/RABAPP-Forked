<?php

namespace App\Http\Controllers;
use App\TaskSub;
use App\Job;
use App\Transformers\TaskSubTransformers;

use Illuminate\Http\Request;

class TaskSubController extends RestController
{
    protected $transformer=TaskSubTransformers::Class;

    public function index()
    {
        $tasksub = TaskSub::orderBy('id_sub','DESC')->get();
        $response = $this->generateCollection($tasksub);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $tasksub = TaskSub::create([
            'name' => $request->name,
        ]);
    
        return response()->json([
            'status' => (bool) $tasksub,
            'data'   => $tasksub,
            'message' => $tasksub ? 'Success' : 'Error Sub'
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validateWith([
            'name' => 'required|max:255'
        ]);

        $tasksub = TaskSub::findOrFail($id);

        $jobs = Job::where('group',$tasksub->name)->get();
        if(!empty($jobs))
        {
            foreach($jobs as $job)
            {
                $job->group = $request->name;
                $job->save();
            }
        }  
        $tasksub->name = $request->name;
        $tasksub->save();

        return response()->json([
            'status' => (bool) $tasksub,
            'data' => $tasksub,
            'message' => $tasksub ? 'Updated' : 'Error update'
        ]);
    }

    public function destroy($id)
    {
        $tasksub = TaskSub::findOrFail($id);
        $status = $tasksub->delete();
        return response()->json([
            'status' => $tasksub,
            'message' => $tasksub ? 'Deleted' : 'Error Delete'
        ]);
    }
}

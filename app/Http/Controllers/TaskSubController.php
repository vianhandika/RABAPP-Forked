<?php

namespace App\Http\Controllers;
use App\TaskSub;
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

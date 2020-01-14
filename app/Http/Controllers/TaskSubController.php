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
        $tasksub = TaskSub::all();
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
}

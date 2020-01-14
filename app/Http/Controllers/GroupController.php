<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Transformers\GroupTransformers;

class GroupController extends RestController
{
    protected $transformer=GroupTransformers::Class;

    public function index()
    {
        $group = Group::all();
        $response = $this->generateCollection($group);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $group = Group::create([
            'name' => $request->name,
        ]);
    
        return response()->json([
            'status' => (bool) $group,
            'data'   => $group,
            'message' => $group ? 'Success' : 'Error Sub'
        ]);
    }
}

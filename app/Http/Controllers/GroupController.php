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
        $group = Group::orderBy('id_groups','DESC')->get();
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

    public function update(Request $request,$id)
    {
        $this->validateWith([
            'name' => 'required|max:255'
        ]);

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->save();

        return response()->json([
            'status' => (bool) $group,
            'data' => $group,
            'message' => $group ? 'Updated' : 'Error update'
        ]);
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $status = $group->delete();
        return response()->json([
            'status' => $group,
            'message' => $group ? 'Deleted' : 'Error Delete'
        ]);
    }
}

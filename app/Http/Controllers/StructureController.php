<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Structure;
use App\Transformers\StructureTransformers;

class StructureController extends RestController
{
    protected $transformer=StructureTransformers::Class;

    public function index()
    {
        $structure = Structure::orderBy('id_structure','DESC')->get();
        $response = $this->generateCollection($structure);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $structure = Structure::create([
            'name' => $request->name,
        ]);
    
        return response()->json([
            'status' => (bool) $structure,
            'data'   => $structure,
            'message' => $structure ? 'Success' : 'Error Sub'
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validateWith([
            'name' => 'required|max:255'
        ]);

        $structure = Structure::findOrFail($id);
        $structure->name = $request->name;
        $structure->save();

        return response()->json([
            'status' => (bool) $structure,
            'data' => $structure,
            'message' => $structure ? 'Updated' : 'Error update'
        ]);
    }

    public function destroy($id)
    {
        $structure = Structure::findOrFail($id);
        $status = $structure->delete();
        return response()->json([
            'status' => $structure,
            'message' => $structure ? 'Deleted' : 'Error Delete'
        ]);
    }
}

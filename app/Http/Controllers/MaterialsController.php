<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materials;
use App\Transformers\MaterialsTransformers;

class MaterialsController extends RestController
{
    protected $transformer=MaterialsTransformers::Class;

    public function index()
    {
        $material = Materials::all();
        $response = $this->generateCollection($material);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $material = Materials::create([
            'kode' => $request->kode,
            'name' => $request->name,
            'type' => $request->type,
            'spesification_1' => $request->spesification_1,
            'spesification_2' => $request->spesification_2,
            'price' => $request->price,
        ]);

        return response()->json([
            'status' => (bool) $material,
            'data' => $material,
            'message' => $material ? 'Success' : 'Error Material'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateWith([
            'kode' => 'required|max:255',
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'price' => 'required|max:255',
            'spesification_1' => 'required|max:255',
            'spesification_2' => 'required|max:255',
        ]);

        $material = Materials::findOrFail($id);
        $material->kode = $request->kode;
        $material->name = $request->name;
        $material->type = $request->type;
        $material->price = $request->price;
        $material->spesification_1 = $request->spesification_1;
        $material->spesification_2 = $request->spesification_2;
        
        $material->save();

        return response()->json([
            'status' => (bool) $material,
            'data' => $material,
            'message' => $material ? 'Success' : 'Error Material'
        ]);
    }

    public function showbyID($id)
    {
        $material = Materials::findOrFail($id);
        return response()->json($material,200);
    }

    public function destroy($id)
    {
        $material = Materials::findOrFail($id);
        $status = $material->delete();
        return response()->json([
            'status' => $material,
            'message' => $material ? 'Deleted' : 'Error Delete'
        ]);
    }
}

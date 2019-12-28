<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satuan;
use App\Transformers\SatuanTransformers;

class SatuanController extends RestController
{
    protected $transformer=SatuanTransformers::Class;

    public function index()
    {
        $satuan = Satuan::all();
        $response = $this->generateCollection($satuan);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $satuan = Satuan::create([
            'name' => $request->name,
        ]);
    
        return response()->json([
            'status' => (bool) $satuan,
            'data'   => $satuan,
            'message' => $satuan ? 'Success' : 'Error Satuan'
        ]);
    }
}

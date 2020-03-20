<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\StoreTransformers;
use App\Store;

class StoreController extends RestController
{
    protected $transformer=StoreTransformers::Class;

    public function index()
    {
        $store = Store::orderBy('id_store','DESC')->get();
        $response = $this->generateCollection($store);
        return $this->sendResponse($response,200);
    }

    public function store(Request $request)
    {
        $store = Store::create([
            'kode' => $request->kode,
            'name' => $request->name,
            'address' => $request->address,
            'type' => $request->type,
            'no_telp' => $request->no_telp,
            'phone' => $request->phone,
            'owner' => $request->owner,
        ]);

        return response()->json([
            'status'=> (bool)$store,
            'data'=>$store,
            'message'=>$store ? 'Success' : 'Error Store'
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'kode' => 'required|max:255',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'type' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'phone' => 'required|max:255',
            'owner' => 'required|max:255',
        ]);

        $store = Store::findOrFail($id);
        $store->kode      = $request->kode;
        $store->name      = $request->name;
        $store->address   = $request->address;
        $store->type      = $request->type;
        $store->no_telp   = $request->no_telp;
        $store->phone     = $request->phone;
        $store->owner     = $request->owner;

        $store->save();

        return response()->json([
            'status'=>(bool) $store,
            'data' => $store,
            'msg'=> $store ? 'Success' : 'Error Edit'
        ]);
    }

    public function showbyID($id)
    {
        $store = Store::find($id);
        return response()->json($store,200);
    }

    public function destroy($id)
    {
        $store = Store::find($id);
        $status = $store->delete();

        return response()->json([
            'status'=> $status,
            'message'=> $status ? 'Deleted' : 'Error Delete'
        ]);
    }

    public function code()
    {
        $store = Store::all()->last();
        if($store != null)
            $parts = explode('-',$store->kode);
        if($store==null){
            $kode = 'St'.'-'.'0001';
        }
        else if(($parts[1]+1)<10) {
            $kode = 'St'.'-'.'000'.($parts[1]+1);
        }else if(($parts[1]+1)>=10 && ($parts[1]+1)<99){
            $kode = 'St'.'-'.'00'.($parts[1]+1);
        }else if(($parts[1]+1)>=99 && ($parts[1]+1)<999){
            $kode = 'St'.'-'.'0'.($parts[1]+1);
        }else if(($parts[1]+1)==1000){
            $kode = 'St'.'-'.($parts[1]+1);
        }else{
            $kode = 'St'.'-'.'001';
        }
        return $kode;
    }
}

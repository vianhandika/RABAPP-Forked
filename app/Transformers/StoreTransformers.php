<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Store;

class StoreTransformers extends TransformerAbstract
{
    public function transform(Store $store)
    {
        return  [
            'id_store'  => $store->id_store,
            'kode'      => $store->kode,
            'name'      => $store->name,
            'address'   => $store->address,
            'type'      => $store->type,
            'no_telp'   => $store->no_telp,
            'phone'     => $store->phone,
            'owner'     => $store->owner,
        ];
    }
}


<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Materials;

class MaterialsTransformers extends TransformerAbstract
{
    public function transform(Materials $material)
    {
        return [
            'kode'              => $material->kode,
            'id_material'       => $material->id_material,
            'name'              => $material->name,
            'type'              => $material->type,
            'satuan'            => $material->satuan->name,
            'id_satuan'         => $material->id_satuan,
            'status'            => $material->status,
            'price'             => $material->price,
            'spesification'     => $material->spesification,
            'id_store'          => $material->stores->id_store,
	    'store'             => $material->stores->name,
            'coefficient'       => 0,
        ];
    }
}


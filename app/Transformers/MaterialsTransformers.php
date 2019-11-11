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
            'spesification_1'   => $material->spesification_1,
            'spesification_2'   => $material->spesification_2,
            'price'             => $material->price,
        ];
    }
}


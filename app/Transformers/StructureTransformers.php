<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Structure;

class StructureTransformers extends TransformerAbstract
{
    public function transform(Structure $structure)
    {
        return [
            'id_structure'      => $structure->id_structure,
            'name'              => $structure->name
        ];
    }
}
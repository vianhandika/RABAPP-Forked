<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\StructureDetails;

class StructureDetailsTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'group'
    ];

    public function transform(StructureDetails $structure_details)
    {
        return [
            'id_structure'          => $structure_details->id_structure,
            'id_rab'                => $structure_details->id_rab,
            'id_structure_details'  => $structure_details->id_structure_details,
            // 'name'                  => $structure_details->structure->name,
        ];
    }

    public function includeGroup(StructureDetails $structure_details)
    {
        return $this->collection($structure_details->groups, new GroupDetailsTransformers);
    }
}
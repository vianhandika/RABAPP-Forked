<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\RAB;

class RABTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'structure'
    ];

    public function transform(RAB $rab)
    {
        return [
            'id_rab'            => $rab->id_rab,
            'id_project'        => $rab->id_project,
            'project'           => $rab->projects->name,
            'kode'              => $rab->kode,
            'total'             => $rab->total_rab,
            'desc'              => $rab->desc,
        ]; 
    }

    public function includeStructure(RAB $rab)
    {
        return $this->collection($rab->structures, new StructureDetailsTransformers);
    }
}
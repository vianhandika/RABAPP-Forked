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
            'kode'              => $rab->kode,
            'sub'               => $rab->sub,
            'total_rab'         => $rab->total_rab,
            'desc'              => $rab->desc,
            'name'              => $rab->projects->name,
            // 'price'             
        ]; 
    }

    public function includeStructure(RAB $rab)
    {
        return $this->collection($rab->structures, new StructureDetailsTransformers);
    }
}
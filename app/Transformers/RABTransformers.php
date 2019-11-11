<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\RAB;

class RABTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'rab_details'
    ];

    public function transform(RAB $rab)
    {
        return [
            'id_rab'            => $rab->id_rab,
            'id_project'        => $rab->id_project,
            'id_ahs'            => $rab->id_ahs,
            'kode'              => $rab->kode,
            'coefficient'       => $rab->coefficient,
            'total_rab'         => $rab->total_rab,
            'name'              => $rab->projects->name,
        ];
    }
    public function includeRABDetails(RAB $rab)
    {
        return $this->collection($rab->detail_rab, new RABDetailsTransformers);
    }
}
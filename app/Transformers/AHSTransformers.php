<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\AHS;

class AHSTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'ahs_details'
    ];

    public function transform(AHS $ahs)
    {
        return [
            'kode'      => $ahs->kode,
            'id_ahs'    => $ahs->id_ahs,
            'id_job'    => $ahs->id_job,
            'total'     => $ahs->total,
            // 'name'      => $ahs->jobs->name,
            // 'satuan'    => $ahs->jobs->satuan
        ];
    }

    public function includeAHSDetails(AHS $ahs)
    {
        return $this->collection($ahs->detail_ahs, new AHSDetailsTransformers);
    }
}
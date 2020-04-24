<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\AHS;

class AHSTransformers2 extends TransformerAbstract
{
    protected $defaultIncludes = [
        'ahs_details'
    ];

    public function transform(AHS $ahs)
    {
        return [
            'kode'                  => $ahs->kode,
            'id_ahs'                => $ahs->id_ahs,
            'id_job'                => $ahs->id_job,
            'id_sub'                => $ahs->id_sub,
            'overhead'              => $ahs->overhead,
            'total_labor'           => $ahs->total_labor,
            'total_material'        => $ahs->total_material,
            'total_equipment'       => $ahs->total_equipment,
            'total_before_overhead' => $ahs->total_before_overhead,
            'total'                 => $ahs->total,
            'name'                  => $ahs->jobs->name,
            'satuan'                => $ahs->jobs->satuan,
            'status'                => $ahs->jobs->status,
            'name_sub'              => $ahs->sub->name
        ];
    }

    public function includeAHSDetails(AHS $ahs)
    {
        return $this->collection($ahs->detail_ahs, new AHSDetailsTransformers);
    }
}
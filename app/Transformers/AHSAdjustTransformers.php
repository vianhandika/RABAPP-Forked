<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\AHSAdjust;

class AHSAdjustTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'ahs_details_adjust'
    ];

    public function transform(AHSAdjust $ahs_adjust)
    {
        return [
            'kode'              => $ahs_adjust->kode,
            'id_ahs_adjust'     => $ahs_adjust->id_ahs_adjust,
            'id_project'        => $ahs_adjust->id_project,
            'id_job'            => $ahs_adjust->id_job,
            'id_sub'            => $ahs_adjust->id_sub,
            'adjustment'        => $ahs_adjust->adjustment,
            'total'             => $ahs_adjust->total,
            'total_labor'       => $ahs_adjust->total_labor,
            'total_material'    => $ahs_adjust->total_material,
            'project'           => $ahs_adjust->projects->name,
            'name'              => $ahs_adjust->jobs->name,
            'satuan'            => $ahs_adjust->jobs->satuan,
            'status'            => $ahs_adjust->jobs->status,
            'name_sub'          => $ahs_adjust->sub->name,
        ];
    }

    public function includeAhsDetailsAdjust(AHSAdjust $ahs_adjust)
    {
        return $this->collection($ahs_adjust->detail_ahs_adjust, new AHSAdjustDetailsTransformers);
    }
}
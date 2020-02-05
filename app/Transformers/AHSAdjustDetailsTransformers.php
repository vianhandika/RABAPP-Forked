<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\AHSAdjustDetails;

class AHSAdjustDetailsTransformers extends TransformerAbstract
{
    public function transform(AHSAdjustDetails $ahs_details_adjust)
    {
        return [
            'id_ahs_details_adjust'     => $ahs_details_adjust->id_ahs_details_adjust,
            'id_ahs_adjust'             => $ahs_details_adjust->id_ahs_adjust,
            'id_material'               => $ahs_details_adjust->id_material,
            'sub_adjusment'             => $ahs_details_adjust->sub_adjusment,
            'sub_total'                 => $ahs_details_adjust->sub_total,
        ];
    }
}
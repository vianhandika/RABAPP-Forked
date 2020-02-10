<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\AHSAdjustDetails;

class AHSAdjustDetailsTransformers extends TransformerAbstract
{
    public function transform(AHSAdjustDetails $ahs_details_adjust)
    {
        return [
            'id_ahs_details_adjust' => $ahs_details_adjust->id_ahs_details_adjust,
            'id_ahs_adjust'         => $ahs_details_adjust->id_ahs_adjust,
            'id_material'           => $ahs_details_adjust->id_material,
            'price_ahs'             => $ahs_details_adjust->price_ahs,
            'sub_adjustment'        => $ahs_details_adjust->sub_adjustment,
            'sub_total'             => $ahs_details_adjust->sub_total,
            
            'kode'                  => $ahs_details_adjust->materials->kode,
            'status'                => $ahs_details_adjust->materials->status,
            'name'                  => $ahs_details_adjust->materials->name,
            'price'                 => $ahs_details_adjust->materials->price,
            'status'                => $ahs_details_adjust->materials->status,
        ];
    }
}
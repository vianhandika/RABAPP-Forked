<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\AHSDetails;

class AHSDetailsTransformers extends TransformerAbstract
{
    public function transform(AHSDetails $ahs_details)
    {
        return [
            'id_ahs_details'     => $ahs_details->id_ahs_details,
            'id_ahs'             => $ahs_details->id_ahs,
            'id_material'        => $ahs_details->id_material,
            'coefficient'        => $ahs_details->coefficient,
            'sub_total'          => $ahs_details->sub_total,
            'kode'               => $ahs_details->materials->kode,
            'price'              => $ahs_details->materials->price,
        ];
    }
}
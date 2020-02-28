<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\AHSLokalDetails;

class AHSLokalDetailsTransformers extends TransformerAbstract
{
    public function transform(AHSLokalDetails $ahs_lokal_details)
    {
        return [
            'id_ahs_lokal_details'  => $ahs_lokal_details->id_ahs_lokal_details,
            'id_ahs_lokal'          => $ahs_lokal_details->id_ahs_lokal,
            'kode'                  => $ahs_lokal_details->kode,
            'id_material'           => $ahs_lokal_details->id_material,
            'coefficient'           => $ahs_lokal_details->coefficient,
            'sub_total'             => $ahs_lokal_details->sub_total,
            'adjustment'            => $ahs_lokal_details->adjustment,
            
            // 'kode'                  => $ahs_lokal_details->materials->kode,
            'name'                  => $ahs_lokal_details->materials->name,
            'type'                  => $ahs_lokal_details->materials->type,
            'price'                 => $ahs_lokal_details->materials->price,
            'status'                => $ahs_lokal_details->materials->status,
        ];
    }
}
<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\AHSDetails;

class AHSDetailsTransformers extends TransformerAbstract
{
    public function transform(AHSDetails $ahs_details)
    {
        return [
            'id_ahs_details'  => $ahs_details->id_ahs_details,
            'id_ahs'          => $ahs_details->id_ahs,
            'id_material'     => $ahs_details->id_material,
            'coefficient'     => $ahs_details->coefficient,
            'sub_total'       => $ahs_details->sub_total,
            
            'kode'            => $ahs_details->materials->kode,
            'name'            => $ahs_details->materials->name,
            'type'            => $ahs_details->materials->type,
            'satuan'          => $ahs_details->materials->satuan,
            'price'           => $ahs_details->materials->price,
            'spesification'   => $ahs_details->materials->spesification,
            'status'          => $ahs_details->materials->status,
            'store'           => $ahs_details->materials->stores->name,
        ];
    }
}
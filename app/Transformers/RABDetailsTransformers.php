<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\RABDetails;

class RABDetailsTransformers extends TransformerAbstract
{
    public function transform(RABDetails $rab_details)
    {
        return [
            'id_rab_details'=> $rab_details->id_rab_details,
            'id_rab'        => $rab_details->id_rab,
            'id_ahs'        => $rab_details->id_ahs,
            'type'          => $rab_details->type,
            'volume'        => $rab_details->volume,
            'coefficient'   => $rab_details->coefficient,
            'sub_total'     => $rab_details->sub_total,
            'kode_ahs'      => $rab_details->ahs->kode,
            'satuan'        => $rab_details->ahs->jobs->satuan,
            'status'        => $rab_details->ahs->jobs->status,
            'price'         => $rab_details->ahs->total
        ];
    }
}
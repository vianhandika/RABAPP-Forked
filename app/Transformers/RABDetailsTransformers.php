<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\RABDetails;

class RABDetailsTransformers extends TransformerAbstract
{
    public function transform(RABDetails $rab_details)
    {
        $data = [
            'id_ahs'            => $rab_details->id_ahs,
            'id_ahs_adjust'     => $rab_details->id_ahs_adjust,
        ];

        if($data['id_ahs_adjust'] != null)
        {
            $data = [
                'id_rab_details'=> $rab_details->id_rab_details,
                'id_sub_details'=> $rab_details->id_sub_details,
                'id_ahs'        => $rab_details->id_ahs,
                'id_ahs_adjust' => $rab_details->id_ahs_adjust,
                'volume'        => $rab_details->volume,
                'coefficient'   => $rab_details->coefficient,
                'sub_total'     => $rab_details->sub_total,
                'ahs_adjust'    => $rab_details->ahs_adjust->jobs->name,
                'satuan_adjust' => $rab_details->ahs_adjust->jobs->satuan,
                'status_adjust' => $rab_details->ahs_adjust->jobs->status,
                'price_adjust'  => $rab_details->ahs_adjust->total
            ];
        }
        if($data['id_ahs'] != null)
        {
            $data = [
                'id_rab_details'=> $rab_details->id_rab_details,
                'id_sub_details'=> $rab_details->id_sub_details,
                'id_ahs'        => $rab_details->id_ahs,
                'id_ahs_adjust' => $rab_details->id_ahs_adjust,
                'volume'        => $rab_details->volume,
                'coefficient'   => $rab_details->coefficient,
                'sub_total'     => $rab_details->sub_total,
                'ahs'           => $rab_details->ahs->jobs->name,
                'satuan'        => $rab_details->ahs->jobs->satuan,
                'status'        => $rab_details->ahs->jobs->status,
                'price'         => $rab_details->ahs->total,
            ];
        }
        return $data;
    }
}
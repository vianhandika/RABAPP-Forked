<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\AHSLokalDetails;
use App\TaskSubDetails;
use App\AHS;

class AHSLokalDetailsTransformers extends TransformerAbstract
{
    public function transform(AHSLokalDetails $ahs_lokal_details)
    {
        $data = [
            'id_ahs_lokal_details'  => $ahs_lokal_details->id_ahs_lokal_details,
            'id_ahs_lokal'          => $ahs_lokal_details->id_ahs_lokal,
            'kode'                  => $ahs_lokal_details->kode,
            'id_material'           => $ahs_lokal_details->id_material,
            'coefficient'           => $ahs_lokal_details->coefficient,
            'sub_total'             => $ahs_lokal_details->sub_total,
            // 'sub_total_adj'         => $ahs_lokal_details->sub_total * $ahs_lokal_details->adjustment,
            'adjustment'            => $ahs_lokal_details->adjustment,
            
            'name'                  => $ahs_lokal_details->materials->name,
            'type'                  => $ahs_lokal_details->materials->type,
            'price'                 => $ahs_lokal_details->materials->price,
            'status'                => $ahs_lokal_details->materials->status,
            'satuan'                => $ahs_lokal_details->materials->satuan->name,
            'volume'                => $ahs_lokal_details->ahs_lokals->volume,        

            'id_structure'  => $ahs_lokal_details->ahs_lokals->task_group->sub->structure->structure->id_structure,
            'id_groups'     => $ahs_lokal_details->ahs_lokals->task_group->sub->group->id_groups,
            'id_sub'        => $ahs_lokal_details->ahs_lokals->task_group->task_sub->id_sub,
            'id_job'        => $ahs_lokal_details->ahs_lokals->id_job,
            'id_sub_details' => $ahs_lokal_details->ahs_lokals->task_group->id_sub_details,
            'status_job'    => $ahs_lokal_details->ahs_lokals->jobs->status,    
                  
        ];
        if($data['status_job'] == "Price")
        {
            $data['sub_total_lokal'] = $data['sub_total'] * $data['adjustment']; 
        }
        if($data['status_job'] == 'Volume')
        {
            $data['sub_total_lokal'] = $data['sub_total']; 
        }
        $data['requirements_ml'] = $data['coefficient'] * $data['volume'] * $data['adjustment'];
        
        $task = TaskSubDetails::find($data['id_sub_details']);
        $ahs = AHS::all();
        foreach($ahs as $ahs_data)
        {
            if($task->id_sub == $ahs_data->id_sub && $data['id_job'] == $ahs_data->id_job)
            {
                $data['id_ahs'] = $ahs_data->id_ahs;
            }
        }
        return $data;
    }
}
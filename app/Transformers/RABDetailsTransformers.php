<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\RABDetails;
use App\TaskSubDetails;
use App\AHS;

class RABDetailsTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'detail'
    ];

    public function transform(RABDetails $rab_details)
    {
        $data =  [
            'id_ahs_lokal'          => $rab_details->id_ahs_lokal,
            'id_sub_details'        => $rab_details->id_sub_details,

            'total_labor'           => $rab_details->total_labor,
            'total_material'        => $rab_details->total_material,
            'total_equipment'       => $rab_details->total_equipment,
            'HSP_before_overhead'   => $rab_details->HSP_before_overhead,
            'HSP'                   => $rab_details->HSP,
            'volume'                => $rab_details->volume,
            
            'overhead'              => $rab_details->overhead,
            'adjustment'            => $rab_details->adjustment,

            'id_job'                => $rab_details->id_job,
            'name'                  => $rab_details->jobs->name,
            'satuan'                => $rab_details->jobs->satuan->name,
            'status'                => $rab_details->jobs->status,
            'keterangan'            => $rab_details->keterangan,
                        
            'id_project'            => $rab_details->task_group->sub->structure->rab->projects->id_project,
            'project'               => $rab_details->task_group->sub->structure->rab->projects->name,
            'name_sub'              => $rab_details->task_group->task_sub->name,

            'id_structure'          => $rab_details->task_group->sub->structure->structure->id_structure,
            'id_groups'             => $rab_details->task_group->sub->group->id_groups,
            'id_sub'                => $rab_details->task_group->task_sub->id_sub,
            'structure'             => $rab_details->task_group->sub->structure->structure->name,
            'floor'                 => $rab_details->task_group->sub->group->name,
            'task'                  => $rab_details->task_group->task_sub->name,

            'id_rab'                => $rab_details->task_group->sub->structure->rab->id_rab,
            'HP'                    => $rab_details->HP,
            'HP_Adjust'             => $rab_details->HP_Adjust, 

        ];
        if($data['keterangan']==null)
        {
            $data['keterangan']=" ";
        }
        if($data['status'] == 'Volume')
        {
            $data['volume_adj'] = $rab_details->volume * $rab_details->adjustment;
            $data['total_labor_adj'] = $rab_details->total_labor;
            $data['total_material_adj'] = $rab_details->total_material;
            $data['total_equipment_adj'] = $rab_details->total_equipment;
            $data['HSP_before_overhead_adj'] = $rab_details->HSP_before_overhead;
            $data['HSP_adj'] = $rab_details->HSP;
        }
        if($data['status'] == 'Price')
        {

            $data['volume_adj'] = $rab_details->volume;
            $data['total_labor_adj'] = $rab_details->total_labor * $rab_details->adjustment;
            $data['total_material_adj'] = $rab_details->total_material * $rab_details->adjustment;
            $data['total_equipment_adj'] = $rab_details->total_equipment * $rab_details->adjustment;
            $data['HSP_before_overhead_adj'] = $rab_details->HSP_before_overhead * $rab_details->adjustment;
            $data['HSP_adj'] = $rab_details->HSP * $rab_details->adjustment;
        }
        $task = TaskSubDetails::find($data['id_sub_details']);
        $ahs = AHS::all();
        foreach($ahs as $ahs_data)
        {
            if($task->id_sub == $ahs_data->id_sub && $data['id_job'] == $ahs_data->id_job)
            {
                $data['id_ahs'] = $ahs_data->id_ahs;
                $data['kode'] = $ahs_data->kode;
            }
        }
        return $data;
    }

    public function includeDetail(RABDetails $rab_details)
    {
        return $this->collection($rab_details->detail_ahs_lokal, new AHSLokalDetailsTransformers);
    }
}
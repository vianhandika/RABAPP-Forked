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
            'id_ahs_lokal'  => $rab_details->id_ahs_lokal,
            'id_sub_details'=> $rab_details->id_sub_details,
            'total_labor'   => $rab_details->total_labor,
            'total_material'=> $rab_details->total_material,
            'HSP'           => $rab_details->HSP,
            'volume'        => $rab_details->volume,
            'adjustment'    => $rab_details->adjustment,
            'HP_Adjust'     => $rab_details->HP_Adjust,
            'volumeAdj'     => $rab_details->adjustment * $rab_details->volume,
            'HSPAdj'        => $rab_details->adjustment * $rab_details->HSP,
            'HP'            => $rab_details->HP,
            
            'id_job'        => $rab_details->id_job,
            'name'          => $rab_details->jobs->name,
            'satuan'        => $rab_details->jobs->satuan,
            'status'        => $rab_details->jobs->status,

            'id_project'    => $rab_details->task_group->sub->structure->rab->projects->id_project,
            'project'       => $rab_details->task_group->sub->structure->rab->projects->name,
            'name_sub'      => $rab_details->task_group->task_sub->name,

            'id_structure'  => $rab_details->task_group->sub->structure->structure->id_structure,
            'id_groups'     => $rab_details->task_group->sub->group->id_groups,
            'id_sub'        => $rab_details->task_group->task_sub->id_sub,
            'structure'     => $rab_details->task_group->sub->structure->structure->name,
            'floor'         => $rab_details->task_group->sub->group->name,
            'task'          => $rab_details->task_group->task_sub->name,

            'id_rab'        => $rab_details->task_group->sub->structure->rab->kode
        ];
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

    public function includeDetail(RABDetails $rab_details)
    {
        return $this->collection($rab_details->detail_ahs_lokal, new AHSLokalDetailsTransformers);
    }
}
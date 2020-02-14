<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\TaskSubDetails;

class TaskSubDetailsTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'rab_details'
    ];

    public function transform(TaskSubDetails $tasksub_details)
    {
        return [
            'id_sub'            => $tasksub_details->id_sub,
            'id_group_details'  => $tasksub_details->id_group_details,
            'id_sub_details'    => $tasksub_details->id_sub_details,
            'id_structure'      => $tasksub_details->sub->structure->structure->id_structure,
            'id_groups'         => $tasksub_details->sub->group->id_groups,
            'id_sub'            => $tasksub_details->task_sub->id_sub,
            'structure'         => $tasksub_details->sub->structure->structure->name,
            'floor'             => $tasksub_details->sub->group->name,
            'task'              => $tasksub_details->task_sub->name
        ];
    }

    public function includeRabDetails(TaskSubDetails $tasksub_details)
    {
        return $this->collection($tasksub_details->detail_rab, new RABDetailsTransformers);
    }
}
<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\GroupDetails;

class GroupDetailsTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'task_sub'
    ];

    public function transform(GroupDetails $group_details)
    {
        return  [
            'id_group_details'      => $group_details->id_group_details,
            'id_groups'             => $group_details->id_groups,
            'id_structure_details'  => $group_details->id_structure_details,
            'id_structure'          => $group_details->structure->structure->id_structure,
            'structure'             => $group_details->structure->structure->name,
            'floor'                 => $group_details->group->name,
        ];
    }

    public function includeTaskSub(GroupDetails $group_details)
    {
        return $this->collection($group_details->task_subs, new TaskSubDetailsTransformers);
    }
}
<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Group;

class GroupTransformers extends TransformerAbstract
{
    public function transform(Group $group)
    {
        return [
            'id_group' => $group->id_groups,
            'name' => $group->name,
        ];
    }
}
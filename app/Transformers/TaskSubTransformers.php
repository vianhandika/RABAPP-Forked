<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\TaskSub;

class TaskSubTransformers extends TransformerAbstract
{   
    public function transform(TaskSub $tasksub)
    {
        return [
            'id_sub'    => $tasksub->id_sub,
            'name'      => $tasksub->name
        ];
    }
}
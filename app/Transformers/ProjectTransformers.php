<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Project;

class ProjectTransformers extends TransformerAbstract
{
    /**
     * Transform Project.
     *
     * @param Project $project
     */
    public function transform(Project $project)
    {
        return [
            'id_project'    => $project->id_project,
            'kode'          => $project->kode,
            'name'          => $project->name,
            'address'       => $project->address,
            'owner'         => $project->owner,
            'date'          => $project->date,
            'no_telp'       => $project->no_telp,
            'phone'         => $project->phone,
            'type'          => $project->type,
            'nominal'       => $project->nominal
        ];
    }
}
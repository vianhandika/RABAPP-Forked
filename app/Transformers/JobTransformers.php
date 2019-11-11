<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Job;

class JobTransformers extends TransformerAbstract
{
    public function transform(Job $job)
    {
        return [
            'kode' => $job->kode,
            'id_job' => $job->id_job,
            'name' => $job->name,
            'satuan' => $job->satuan,
            'details' => $job->details
        ];
    }
}
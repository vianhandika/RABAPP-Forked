<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Job;

class JobTransformers extends TransformerAbstract
{
    public function transform(Job $job)
    {
        return [
            'kode'      => $job->kode,
            'id_job'    => $job->id_job,
            'id_satuan' => $job->id_satuan,
            'name'      => $job->name,
            'satuan'    => $job->satuan->name,
            'status'    => $job->status,
            'details'   => $job->details
        ];
    }
}
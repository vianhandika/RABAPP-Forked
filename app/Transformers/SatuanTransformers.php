<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Satuan;

class SatuanTransformers extends TransformerAbstract
{
    public function transform(Satuan $satuan)
    {
        return [
            'id_satuan' => $satuan->id_satuan,
            'name'      => $satuan->name
        ];
    }
}
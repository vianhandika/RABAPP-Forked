<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AHSLokalDetails extends Model
{
    use SoftDeletes;

    protected $table = 'ahs_lokal_details';
    protected $primaryKey = 'id_ahs_lokal_details';
    public $timestamp = true;

    protected $fillable = [
        'id_ahs_lokal','kode','id_material','coefficient','sub_total','adjustment'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function ahs_lokals()
    {
        return $this->belongsTo('App\RABDetails','id_ahs_lokal');
    }

    public function materials()
    {
        return $this->belongsTo('App\Materials','id_material');
    }
}

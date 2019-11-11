<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RABDetails extends Model
{
    //
    protected $table = 'r_a_b_details';
    protected $primaryKey = 'id_rab_details';
    public $timestamps = true;

    protected $fillable = [
        'id_rab', 'id_ahs', 'volume','sub_total'
    ];

    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function rab()
    {
        return $this->belongsTo('App\RAB','id_rab');
    }
    public function ahs()
    {
        return $this->belongsTo('App\AHS','id_ahs');
    }
}


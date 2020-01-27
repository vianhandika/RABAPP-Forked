<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RABDetails extends Model
{
    use SoftDeletes;
    
    protected $table = 'r_a_b_details';
    protected $primaryKey = 'id_rab_details';
    public $timestamps = true;

    protected $fillable = [
        'id_sub_details', 'id_ahs', 'volume','sub_total', 'coefficient', 'hp'
    ];

    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function task_sub()
    {
        return $this->belongsTo('App\TaskSubDetails','id_sub_details');
    }

    public function ahs()
    {
        return $this->belongsTo('App\AHS','id_ahs');
    }
}


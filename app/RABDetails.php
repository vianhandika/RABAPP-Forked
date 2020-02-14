<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RABDetails extends Model
{
    use SoftDeletes;
    
    protected $table = 'ahs_lokals';
    protected $primaryKey = 'id_ahs_lokal';
    public $timestamps = true;

    protected $fillable = [
        'id_sub_details', 'id_job','total_labor','total_material','HSP', 'volume','adjustment', 'HP'
    ];

    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function task_group()
    {
        return $this->belongsTo('App\TaskSubDetails','id_sub_details');
    }

    public function jobs()
    {
        return $this->belongsTo('App\Job','id_job');
    }

    public function detail_ahs_lokal()
    {
        return $this->hasMany('App\AHSLokalDetails','id_ahs_lokal');
    }
}


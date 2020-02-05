<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AHSAdjust extends Model
{
    use SoftDeletes;
    protected $table = 'a_h_s_adjusts';
    protected $primaryKey = 'id_ahs_adjust';
    public $timestamp = true;

    protected $fillable = [
        'id_project','id_job', 'id_sub','adjustment','total_labor','total_material','total'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function detail_ahs_adjust()
    { 
        return $this->hasMany('App\AHSAdjustDetails','id_ahs_adjust');
    }

    public function jobs()
    { 
        return $this->belongsTo('App\Job','id_job');
    }

    public function projects()
    {
        return $this->belongsTo('App\Project','id_project');
    }

    public function sub()
    {
        return $this->belongsTo('App\TaskSub','id_sub');
    }
}

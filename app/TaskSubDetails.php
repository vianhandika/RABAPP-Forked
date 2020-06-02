<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskSubDetails extends Model
{
    use SoftDeletes;

    protected $table = 'task_sub_details';
    protected $primaryKey = 'id_sub_details';
    public $timestamp = true;

    protected $fillable = [
        'id_sub','id_group_details'
    ];

    protected $dates = [
        'created_at', 'updated_at','deleted_at',
    ];

    public function task_sub()
    {
        return $this->belongsTo('App\TaskSub','id_sub');
    }

    public function detail_rab()
    {
        return $this->hasMany('App\RABDetails','id_sub_details');
    }

    public function sub()
    {
        return $this->belongsTo('App\GroupDetails','id_group_details');
    }
}

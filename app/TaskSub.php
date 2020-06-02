<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskSub extends Model
{
    use SoftDeletes;

    protected $table = 'task_subs';
    protected $primaryKey = 'id_sub';
    public $timestamp = true;

    protected $fillable = [
        'name', 
    ];

    protected $dates = [
        'created_at', 'updated_at','deleted_at',
    ];

    public function ahs()
    {
        return $this->hasMany('App\AHS','id_sub');
    }

    public function task_sub_details()
    {
        return $this->hasMany('App\TaskSubDetails','id_sub');
    }
}

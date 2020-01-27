<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupDetails extends Model
{
    use SoftDeletes;
    protected $table = 'group_details';
    protected $primaryKey = 'id_group_details';
    public $timestamp = true;

    protected $fillable = [
        'id_groups', 'id_structure_details', 'name'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group','id_groups');
    }

    public function task_subs()
    {
        return $this->hasMany('App\TaskSubDetails','id_group_details');
    }

    public function structure()
    {
        return $this->belongsTo('App\StructureDetails','id_structure_details');
    }
}

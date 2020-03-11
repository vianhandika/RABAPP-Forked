<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RAB extends Model
{
    use SoftDeletes;

    protected $table = 'rabs';
    protected $primaryKey = 'id_rab';
    public $timestamp = true;

    protected $fillable = [
        'id_project', 'kode', 'total_rab', 'desc'
    ];

    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function projects()
    {
        return $this->belongsTo('App\Project','id_project');
    }
    
    public function structures()
    {
        return $this->hasMany('App\StructureDetails','id_rab');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RAB extends Model
{
    //
    use SoftDeletes;

    protected $table = 'rabs';
    protected $primaryKey = 'id_rab';
    public $timestamp = true;

    protected $fillable = [
        'id_project', 'id_ahs', 'coefficient','total_rab', 'kode'
    ];

    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function projects()
    {
        return $this->belongsTo('App\Project','id_project');
    }
    
    public function detail_ahs()
    {
        return $this->hasMany('App\AHS','id_ahs');
    }

    public function detail_rab()
    {
        return $this->hasMany('App\RABDetails','id_rab');
    }
}

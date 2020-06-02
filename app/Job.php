<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    protected $table = 'jobs';
    protected $primaryKey = 'id_job';
    public $timestamp = true;

    protected $fillable = [
        'id_satuan','kode','name','status','details' 
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function ahs()
    {
        return $this->hasMany('App\AHS','id_ahs');
    }

    public function ahs_lokal()
    {
        return $this->hasMany('App\RABDetails','id_ahs_lokal');
    }

    public function satuan()
    {
        return $this->belongsTo('App\Satuan','id_satuan');
    }
}

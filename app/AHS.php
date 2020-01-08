<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AHS extends Model
{
    //
    use SoftDeletes;
    protected $table = 'a_h_s_s';
    protected $primaryKey = 'id_ahs';
    public $timestamp = true;

    protected $fillable = [
        'kode','id_job', 'total'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function detail_ahs()
    { 
        return $this->hasMany('App\AHSDetails','id_ahs');
    }
    
    public function jobs()
    { 
        return $this->belongsTo('App\Job','id_job');
    }
}

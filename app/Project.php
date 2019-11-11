<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;

    protected $table = 'projects';
    protected $primaryKey = 'id_project';
    public $timestamp = true;

    protected $fillable = [
        'kode','name', 'address', 'owner','date','no_telp','phone', 'type', 'nominal'
    ];
    
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function rab()
    {
        return $this->hasMany('App\RAB','id_rab');
    }
}

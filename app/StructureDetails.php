<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StructureDetails extends Model
{
    use SoftDeletes;
    protected $table = 'structure_details';
    protected $primaryKey = 'id_structure_details';
    public $timestamp = true;

    protected $fillable = [
        'id_rab','id_structure',
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
    
    public function structure()
    {
        return $this->belongsTo('App\Structure','id_structure');
    }

    public function groups()
    {
        return $this->hasMany('App\GroupDetails','id_structure_details');
    }

    public function rab()
    {
        return $this->belongsTo('App\RAB','id_rab');
    }
}

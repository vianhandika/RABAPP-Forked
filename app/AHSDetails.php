<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AHSDetails extends Model
{
    //
    use SoftDeletes;

    protected $table = 'ahs_details';
    protected $primaryKey = 'id_ahs_details';
    public $timestamp = true;

    protected $fillable = [
        'id_ahs','id_material', 'coefficient', 'sub_total'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function ahs()
    {
        return $this->belongsTo('App\AHS','id_ahs');
    }

    public function materials()
    {
        return $this->belongsTo('App\Materials','id_material');
    }
}

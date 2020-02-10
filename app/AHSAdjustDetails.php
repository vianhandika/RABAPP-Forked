<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AHSAdjustDetails extends Model
{
    use SoftDeletes;

    protected $table = 'a_h_s_adjust_details';
    protected $primaryKey = 'id_ahs_details_adjust';
    public $timestamp = true;

    protected $fillable = [
        'id_ahs_adjust','id_material','price_ahs','sub_adjustment','sub_total'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function ahs_adjust()
    {
        return $this->belongsTo('App\AHSAdjust','id_ahs_adjust');
    }

    public function materials()
    {
        return $this->belongsTo('App\Materials','id_material');
    }
}

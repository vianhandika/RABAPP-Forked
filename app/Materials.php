<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials extends Model
{
    use SoftDeletes;

    protected $table = 'materials';
    protected $primaryKey = 'id_material';
    public $timestamp = true;

    protected $fillable = [
        'id_store', 'id_satuan','kode', 'name', 'type', 'spesification', 'price','status'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function stores()
    {
        return $this->belongsTo('App\Store','id_store');
    }
    
    public function detail_ahs()
    {
        return $this->hasMany('App\AHSDetails','id_material');
    }

    public function detail_ahs_lokal()
    {
        return $this->hasMany('App\AHSLokalDetails','id_material');
    }

    public function satuan()
    {
        return $this->belongsTo('App\Satuan','id_satuan');
    }
}

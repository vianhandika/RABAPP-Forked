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
        'id_store', 'kode', 'name', 'type', 'spesification', 'price','satuan', 'status'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];

    public function stores()
    {
        return $this->belongsTo('App\Store','id_store');
    }
}

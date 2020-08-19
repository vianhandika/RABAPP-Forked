<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    //
    use SoftDeletes;

    protected $table = 'stores';
    protected $primaryKey = 'id_store';
    public $timestamp = true;

    protected $fillable = [
        'kode','name', 'address', 'type', 'no_telp', 'phone', 'owner'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function materials()
    {
        return $this->hasMany('App\Materials','id_store');
    }
}

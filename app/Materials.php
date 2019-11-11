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
        'kode','name', 'type','spesification_1', 'spesification_2','price' 
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Structure extends Model
{
    use SoftDeletes;
    protected $table = 'structures';
    protected $primaryKey = 'id_structure';
    public $timestamp = true;

    protected $fillable = [
        'kode','name'
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
}

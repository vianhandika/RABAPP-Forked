<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $table = 'groups';
    protected $primaryKey = 'id_groups';
    public $timestamp = true;

    protected $fillable = [
        'kode','name', 
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
}

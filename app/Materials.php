<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'unit','type', 'spesification', 'coefficient','conversion' 
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
}

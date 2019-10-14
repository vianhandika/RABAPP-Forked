<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'unit','details' 
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
}

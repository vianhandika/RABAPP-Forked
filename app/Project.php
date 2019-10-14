<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'date','address','contact' 
    ];
    protected $dates = [
        'created_at', 'deleted_at','updated_at'
    ];
}

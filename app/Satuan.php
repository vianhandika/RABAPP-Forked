<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'satuans';
    protected $primaryKey = 'id_satuan';
    public $timestamp = true;

    protected $fillable = [
        'name'
    ];

    protected $dates = [
        'created_at', 'updated_at','deleted_at',
    ];

    public function satuan_materials()
    {
        return $this->hasMany('App\Materials','id_satuan');
    }

    public function satuan_jobs()
    {
        return $this->hasMany('App\Job','id_satuan');
    }
}

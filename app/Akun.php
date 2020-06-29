<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Akun as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Akun extends Model
{
    use SoftDeletes, HasApiTokens, Notifiable;
    protected $table = 'akuns';
    protected $primaryKey = 'Id_Akun';
    public $timestamp = true;
    protected $fillable = [
        'Username',
        'Password'
    ];
}

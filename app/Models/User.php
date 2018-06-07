<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 't0101_user';

    protected $fillable = [
        'avatar_id',
        'username',
        'password'
    ];

    protected $hidden = [
        'remember_token', 'updated_at', 'deleted_at', 'password'
    ];  
}

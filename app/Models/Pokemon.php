<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model {
    public $table = 't0301_pokemon';
    protected $fillable = [
        'name',
        'sprite',
        'image',
        'health_point',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $timestamps = true;

}

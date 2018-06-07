<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model {
    public $table = 't0201_avatar';
    protected $fillable = [
        'ref_id',
        'total_users'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $timestamps = true;
}

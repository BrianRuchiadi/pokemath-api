<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model {
    public $table = 't0401_stage';
    protected $fillable = [
        'stage_no',
        'exp_needed',
        'pokemon_amount',
        'pokemon_uncommon_probability',
        'pokemon_common_probability',
        'pokemon_rare_probability',
        'pokemon_legendary_probability'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $timestamps = true;

}

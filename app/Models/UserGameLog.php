<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGameLog extends Model {
    public $table = 't0103_user_game_log';
    protected $fillable = [
        'user_id',
        'level',
        'exp_accumulated',
        'cash',
        'current_stage',
        'battle_won',
        'pokemon_owned',
        'power_multiplication',
        'power_division',
        'power_addition',
        'power_subtraction'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $timestamps = true;

}

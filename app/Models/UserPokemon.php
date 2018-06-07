<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPokemon extends Model {
    public $table = 't0102_user_pokemon';
    protected $fillable = [
        'user_id',
        'pokemon_id',
        'capture_amount',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function pokemon() {
        return $this->belongsTo('App\Models\Pokemon', 'pokemon_id', 'id');
    }
}

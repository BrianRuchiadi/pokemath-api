<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagePokemon extends Model {
    public $table = 't0402_stage_pokemon';
    protected $fillable = [
        'stage_id',
        'pokemon_id',
        'rarity'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $timestamps = true;

    public function pokemon() {
        return $this->belongsTo('App\Models\Pokemon', 'pokemon_id', 'id');
    }

}

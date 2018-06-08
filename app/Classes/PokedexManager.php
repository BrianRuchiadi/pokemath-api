<?php
namespace App\Classes;

use DB;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserPokemon;
use App\Models\Pokemon;

class PokedexManager {
    
    function __construct() {
    }

    function getUserPokedex(User $user) {
        $userPokedex = $this->userPokedexSql($user->id);

        return $userPokedex;
    }

    function insertOrUpdatePokedex(User $user, Pokemon $pokemon) {
        $pokedexRec = UserPokemon::where('user_id', $user->id)
            ->where('pokemon_id', $pokemon->id)
            ->first();

        if ($pokedexRec) {
            $pokedexRec->capture_amount = $pokedexRec->capture_amount + 1;
            $pokedexRec->save();
            return;
        }

        UserPokemon::create([
            'user_id' => $user->id,
            'pokemon_id' => $pokemon->id,
            'capture_amount' => 1
        ]);
        return;
    }

    function userPokedexSql($userId) {
        $sql = "
            SELECT p.`id`, p.`name`, up.`user_id`, p.`image`
                FROM `t0301_pokemon` p
                    LEFT JOIN `t0102_user_pokemon` up
                    ON p.`id` = up.`pokemon_id`
                    AND up.`user_id` = :userId
                ORDER BY p.`id`
        ";

        $userPokedex = DB::select($sql, [
            'userId' => $userId
        ]);
        return $userPokedex;
    }
    
}
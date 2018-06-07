<?php
namespace App\Classes;

use DB;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Stage;
use App\Models\Pokemon;
use App\Models\StagePokemon;

class StageManager {
    
    function __construct() {
    }

    function determinePokemons(Stage $stage) {
        $pokemons = [];
        $stagePokemons = StagePokemon::where('stage_id', $stage->id)
            ->with('pokemon')
            ->get()
            ->shuffle();

        $stagePokemons = $stagePokemons->take($stage->pokemon_amount)->toArray();

        for ($i = 0; $i < count($stagePokemons); $i++) {
            array_push($pokemons, $stagePokemons[$i]['pokemon']);
        }

        return $pokemons;
    }

    function getAllStagesConcise() {
        $stagesConcise = $this->allStagesConciseSql();

        return $stagesConcise;
    }

    function allStagesConciseSql() {
        $sql = "
            SELECT 
                s.`stage_no`,
                s.`exp_needed`
                FROM `t0401_stage` s
                ORDER BY s.`stage_no`
        ";

        $results = DB::select($sql);

        return $results;

    }
}
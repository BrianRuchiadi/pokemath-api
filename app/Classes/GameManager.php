<?php
namespace App\Classes;

use DB;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Pokemon;
use App\Models\UserGameLog;
use App\Models\Stage;

class GameManager {
    
    function __construct() {
    }

    function getGameComponent(User $user) {
        $userPokedex = $this->getGameComponentSql($user->id);

        return $userPokedex;
    }

    function updateUserBattleLog(User $user, Pokemon $pokemon) {
        $userGameLog = UserGameLog::where('user_id', $user->id)->first();

        $userGameLog->exp_accumulated = $userGameLog->exp_accumulated + $pokemon->health_point;
        $userGameLog->cash = $userGameLog->cash + ($pokemon->health_point / 2);
        $userGameLog->battle_won = $userGameLog->battle_won + 1;
        $userGameLog->pokemon_owned = $userGameLog->pokemon_owned + 1;

        $currentStage = $this->getCurrentStage($userGameLog->exp_accumulated);
        $currentLevel = $this->getCurrentLevel($userGameLog->exp_accumulated, $userGameLog->level);

        $userGameLog->current_stage = $currentStage;
        $userGameLog->level = $currentLevel;

        $userGameLog->save();
    }

    function getCurrentStage($exp) {
        $currentStage = 1;
        $stages = Stage::orderBy('exp_needed')->get();

        foreach ($stages as $stage) {
            if ($exp >= $stage->exp_needed) {
                $currentStage = $stage->stage_no;
            }
        }

        return $currentStage;
    }

    function getCurrentLevel($exp, $level) {
        $currentLevel = 1;
        $firstBaseLevelUpPoint = 100;
        $nextBaseLevelUpIncrementPoint = 50;

        if ($level == 1) {
            if ($exp >= $firstBaseLevelUpPoint) {  $currentLevel = 2;  }
            return $currentLevel;
        }

        if ($level == 2) {
            $previousPoint = $firstBaseLevelUpPoint;
            $nextPoint = ($level * $firstBaseLevelUpPoint) + ($level * $nextBaseLevelUpIncrementPoint);
            
            $levelUpPoint = $previousPoint + $nextPoint;

            if ($exp >= $levelUpPoint) { $currentLevel = 3; }
            return $currentLevel;
        }

        $previousPoint = (($level - 1) * $firstBaseLevelUpPoint) + (($level - 1) * $nextBaseLevelUpIncrementPoint);
        $nextPoint = ($level * $firstBaseLevelUpPoint) + ($level * $nextBaseLevelUpIncrementPoint);

        $levelUpPoint = $previousPoint + $nextPoint;        
        $currentLevel = $level;

        if ($exp >= $levelUpPoint) { $currentLevel = $level + 1; }
        
        return $currentLevel;
    }

    function getGameComponentSql($userId) {
        $sql = "
            SELECT 
                u.`username`,
                ug.`user_id`,
                u.`avatar_id`,
                ug.`current_stage`,
                ug.`level`,
                ug.`exp_accumulated`,
                ug.`cash`,
                ug.`battle_won`,
                ug.`power_multiplication`,
                ug.`power_division`,
                ug.`power_addition`,
                ug.`power_subtraction`,
                COUNT(up.`id`) as 'total_pokemon_owned'
                FROM `t0101_user` u
                    LEFT JOIN `t0103_user_game_log` ug
                    ON u.`id` = ug.`user_id`

                    LEFT JOIN `t0102_user_pokemon` up
                    ON u.`id` = up.`user_id`
                WHERE u.`id` = :userId
                GROUP BY ug.`user_id`
        ";

        $userPokedex = DB::select($sql, [
            'userId' => $userId
        ]);
        return $userPokedex;
    }
    
}
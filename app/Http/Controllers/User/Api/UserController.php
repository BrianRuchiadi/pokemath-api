<?php 

namespace App\Http\Controllers\User\Api;

use DB;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use NoProtocol\Encryption\MySQL\AES\Crypter;
use MySQLHandler\MySQLHandler;
use Monolog\Logger;

use App\Classes\PokedexManager;
use App\Classes\GameManager;

use App\Models\User;
use App\Models\Pokemon;
use App\Models\Stage;
use App\Models\UserGameLog;

class UserController extends Controller {

    // function logger(Request $request) {
    //     $pdo = DB::connection()->getPdo();
    //     $logErrMaster = new Logger('OrderController');

    //     $logErrMaster->pushHandler(new MySQLHandler($pdo, "t9901_log_error_master", [], Logger::DEBUG));
    // }

    function getUserPokedex(Request $request) {
        $pokedexM = new PokedexManager();
        $pokedex = $pokedexM->getUserPokedex(Auth::User());
        
        return $pokedex;
    }

    function getGameComponent(Request $request) {
        $gameM = new GameManager();
        $gameComponent = $gameM->getGameComponent(Auth::User());

        return $gameComponent;
    }

    function updateUserLog(Request $request, Pokemon $pokemon) {
        $pokedexM = new PokedexManager();
        $pokedexM->insertOrUpdatePokedex(Auth::User(), $pokemon);

        $gameM = new GameManager();
        $gameM->updateUserBattleLog(Auth::User(), $pokemon);
        $gameComponent = $gameM->getGameComponent(Auth::User());

        return $gameComponent;
    }

    function updateAttack(Request $request) {
        $userGameLog = UserGameLog::where('user_id', Auth::User()->id)->first();
        $userGameLog->cash = $request->userLog['cash'];
        $userGameLog->power_multiplication = $request->userLog['power_multiplication'];
        $userGameLog->power_division = $request->userLog['power_division'];
        $userGameLog->power_addition = $request->userLog['power_addition'];
        $userGameLog->power_subtraction = $request->userLog['power_subtraction'];

        $userGameLog->save();
    }
}
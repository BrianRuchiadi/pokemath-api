<?php 

namespace App\Http\Controllers\User\Api;

use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use NoProtocol\Encryption\MySQL\AES\Crypter;
use MySQLHandler\MySQLHandler;
use Monolog\Logger;

use App\Classes\StageManager;

use App\Models\Stage;

class StageController extends Controller {

    // function logger(Request $request) {
    //     $pdo = DB::connection()->getPdo();
    //     $logErrMaster = new Logger('OrderController');

    //     $logErrMaster->pushHandler(new MySQLHandler($pdo, "t9901_log_error_master", [], Logger::DEBUG));
    // }

    function getAllStagesConcise(Request $request) {
        $stageM = new StageManager();
        $stagesConcise = $stageM->getAllStagesConcise();

        return $stagesConcise;
    }

    function getStagePokemons(Request $request, Stage $stage) {
        $stageM = new StageManager();
        $pokemons = $stageM->determinePokemons($stage);
        
        return $pokemons;
    }
}
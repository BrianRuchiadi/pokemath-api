<?php 

namespace App\Http\Controllers\User\Auth;

use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use NoProtocol\Encryption\MySQL\AES\Crypter;
use MySQLHandler\MySQLHandler;
use Monolog\Logger;

class AuthController extends Controller {

    // function logger(Request $request) {
    //     $pdo = DB::connection()->getPdo();
    //     $logErrMaster = new Logger('OrderController');

    //     $logErrMaster->pushHandler(new MySQLHandler($pdo, "t9901_log_error_master", [], Logger::DEBUG));
    // }

    function login(Request $request) {
        return 'login API';
    }

    function register(Request $request, Stage $stage) {
        return 'register API';
    }
}
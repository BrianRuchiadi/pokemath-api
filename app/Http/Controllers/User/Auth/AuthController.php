<?php 

namespace App\Http\Controllers\User\Auth;

use DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use NoProtocol\Encryption\MySQL\AES\Crypter;
use MySQLHandler\MySQLHandler;
use Monolog\Logger;

use App\Models\User;
use App\Models\UserGameLog;

class AuthController extends Controller {

    // function logger(Request $request) {
    //     $pdo = DB::connection()->getPdo();
    //     $logErrMaster = new Logger('OrderController');

    //     $logErrMaster->pushHandler(new MySQLHandler($pdo, "t9901_log_error_master", [], Logger::DEBUG));
    // }

    function login(Request $request) {
        return 'login API';
    }

    function register(Request $request) {
        $user = User::where('username', $request->username)->first();

        if ($user) {
            return response()->json([
                "username" => 'username is taken'
            ], 500);
        }

        $password = $request->username;
        $token = null;

        DB::transaction(function() use($request, &$password) {
            $newUser = User::create([
                'username' => $request->username,
                'avatar_id' => $request->avatarId,
                'password' => Hash::make($password)
            ]);
            $userGameLog = UserGameLog::create(['user_id' => $newUser->id]);
    
            $token = $newUser->createToken('pokemath')->accessToken;
            $password = $request->username . $newUser->id;
    
            $newUser->update([
                'password' => Hash::make($password)
            ]);
        });
       
        
        return response()->json([
            'password' => $password,
            'accessToken' => $token
        ]);
    }
}
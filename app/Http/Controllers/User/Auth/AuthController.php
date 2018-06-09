<?php 

namespace App\Http\Controllers\User\Auth;

use Auth;
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
        if (!$request->username) {
            return response()->json([
                "username" => 'username must be filled'
            ], 500);
        }

        if (!$request->password) {
            return response()->json([
                "password" => 'password must be filled'
            ], 500);
        }

        $validUser = Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ]);

        if (!$validUser) {
            return response()->json([
                "password" => 'credentials invalid'
            ], 500);
        }

        $user = User::where('username', $request->username)->first();

        return response()->json([
            'token' => $user->createToken('Pokemath')->accessToken
        ]);
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

        DB::transaction(function() use($request, &$password, &$token) {
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

    function updatePassword(Request $request) {
        if (!$request->password) {
            return response()->json([
                "password" => 'password must be filled'
            ], 500);
        }

        if (strlen($request->password) < 6) {
            return response()->json([
                "password" => 'password must contain more than 6 characters'
            ], 500);
        }

        $newPassword = Hash::make($request->password);

        $user = Auth::user();
        $user->update([
            'password' => $newPassword
        ]);
    }
}
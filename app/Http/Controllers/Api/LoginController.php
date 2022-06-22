<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
class LoginController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::connection('mysql')->table('users')->where('nik',$username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $generateToken = bin2hex(random_bytes(40));
        $save=DB::connection('mysql')->table('users')->where('nik',$username)->where('role_id',1)->update([
            'token' => $generateToken,
            'batas' => jam_berikutnya(),
        ]);
        $useron = DB::connection('mysql')->table('users')->select('token')->where('nik',$username)->where('role_id',1)->first();
        return response()->json($useron);
    }
}

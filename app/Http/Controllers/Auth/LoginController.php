<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function credentials(\Illuminate\Http\Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['nik'=>$request->get('email'),'password'=>$request->get('password')];
        }else{
            return ['nik' => $request->{$this->username()}, 'password' => $request->password];
        }
        return $request->only($this->username(), 'password');
    }
    public function programaticallyEmployeeLogin(Request $request, $personnel_no)
    {
        $personnel_no = base64_decode($personnel_no);
        try {
        
        $userlogin = User::where('nik', $personnel_no)->first();
        //dd($userlogin);
        if(is_null($userlogin)){
            return redirect('https://sso.krakatausteel.com');
        }else{
            Auth::loginUsingId($userlogin->id);
            return redirect()
            ->route('home');
        }
        
        } catch (ModelNotFoundException $e) {
    
        return redirect('https://sso.krakatausteel.com');
        }

        return $this->sendLoginResponse($request);
    }
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

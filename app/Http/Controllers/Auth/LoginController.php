<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

// use Bestmomo\LaravelEmailConfirmation\Traits\AuthenticatesUsers; //Change traits to use Email Verification by BestMomo
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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (!$this->checkCredential($request)) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        $user = $this->guard()->getLastAttempted();

        if ($user->status == "Aktif") {
            // If user is confirmed we make the login and delete session information if needed
            $this->attemptLogin($request);
            if ($request->session()->has('user_id')) {
                $request->session()->forget('user_id');
            }

            // if($user->email_verified_at == "" && $user->email != ""){
            //     $request->session()->put('user_id', $user->id);
            // }
            if($user->email != ""){
                $request->session()->put('user_id', $user->id);
            }
            //return $this->sendLoginResponse($request);
            return response()->json("Welcome ".$user->name);
        }

        $request->session()->put('user_id', $user->id);

        //return back()->with('confirmation-danger', __('confirmation::confirmation.again'));
        return response()->json(trans('confirmation::confirmation.again'));
    }

    /**
     * Check credential.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function checkCredential($request)
    {
        return $this->guard()->validate($this->credentials($request));
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

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

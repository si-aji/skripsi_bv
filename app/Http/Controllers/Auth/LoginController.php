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
     * Get the needed authorization credentials from the request
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request){
        $field = $this->field($request);
        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password')
        ];
    }

    /**
     * Determine if the request field is email or username
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function field(Request $request){
        $email = $this->username();
        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    /**
     * Get the login username to be used by controller
     *
     * @return string
     */
    public function username(){
        return 'email';
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
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        //return $this->loggedOut($request) ?: redirect('/');
        return response()->json("Successfully logged out!");
    }

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

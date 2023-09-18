<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use DB;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Check if the user exists in the member_registartions table based on email or phone
        $user = DB::table('member_registartions')
        ->where('email', $credentials['email'])
            ->orWhere('phone', $credentials['email'])
            ->first();
//dd($user);
        if ($user) {
            // If a user is found, attempt to log in using the retrieved email and password
            return Auth::guard()->attempt(
                [
                    'email' => $user->email,
                    'password' => $credentials['password'],
                ],
                $request->filled('remember')
            );
        }

        return false; // No user found, login attempt fails
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->input($this->username()),
            'password' => $request->input('password'),
        ];
    }
}

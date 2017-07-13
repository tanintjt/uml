<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Auth;
use Socialite;

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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function index()
    {
        $title = 'Login to your account';
        return view('auth/login/index', compact('title'));
    }

    /**
     * Check a user credentials.
     *
     * @return Response
     */

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'status' => 1 ], $request->input('remember'))) {


            if(Auth::user()->hasRole('super-administrator')) {
                //return redirect($this->redirectTo);
                return redirect('admin/service-center');
            } else {
                if(Auth::user()->hasRole(['administrator', 'manager'])) {
                    return redirect('admin/service-center');
                } else {

                    Auth::logout();
                    return redirect('login')->withErrors([
                        'error' => 'Sorry, you do not have proper permission to access the web system.',
                    ]);
                }
            }
        }

        return redirect('login')->withErrors([
            'error' => 'The email or the password is invalid. Please try again.',
        ]);
    }

    /**
     * Redirect the user to logout.
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->intended($this->redirectTo);
    }

    /**
     * Redirect the user to the Social authentication page.
     *
     * @return Response
     */
    public function provider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function providerCallback($provider)
    {

        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        //return $user->token;
        return redirect($this->redirectTo);

        //$github = Socialite::driver($provider)->userFromToken($token);


    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
 */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        $newuser = User::create([
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'password' => bcrypt($user->id),
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'status' => 1,
                    //'api_token'=>isset($user->api_token)?$user->api_token:Null
                ]);

        //$user->attachRole($newuser->id);

        return $newuser;
    }
}

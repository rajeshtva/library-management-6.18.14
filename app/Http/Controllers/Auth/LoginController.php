<?php

namespace App\Http\Controllers\Auth;

use App\Book;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

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

    protected function  authenticated()
    {
        if (auth()->user()->hasRole('admin')) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/home');
        }
    }


    // protected $redirectTo = '/';
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');


        $cart = session()->get('cart');
        if (empty($cart)) {
            $cart = array();
            session()->put('cart', $cart);
            // dump($cart);
        }
    }
    /**
     * @TODO: here i have to implement if a user needs to be authenticated then it must go to desired page directly. if nothing then it must go to home page of their respective users. 
     */

    // public function showLoginForm()
    // {
    //     session(['link' => url()->previous()]);
    //     return view('auth.login');
    // }

    // protected function authenticated(Request $request, $user)
    // {
    //     return redirect(session('link'));
    // }
}

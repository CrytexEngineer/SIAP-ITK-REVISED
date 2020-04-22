<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo;
    public function redirectTo()
    {
        switch (Auth::user()->role) {

            case 1:
                $this->redirectTo = '/superadmin';
                return $this->redirectTo;
                break;
            case 2:
                $this->redirectTo = '/admin';
                return $this->redirectTo;
                break;
            case 3:
                $this->redirectTo = '/observer';
                return $this->redirectTo;
                break;
            case 4:
                $this->redirectTo = '/warek';
                return $this->redirectTo;
                break;
            case 5:
                $this->redirectTo = '/kajur';
                return $this->redirectTo;
                break;
            case 6:
                $this->redirectTo = '/kaprodi';
                return $this->redirectTo;
                break;

            case 7:
                $this->redirectTo = '/dikjur';
                return $this->redirectTo;
                break;

            case 8:
                $this->redirectTo = '/diksat';
                return $this->redirectTo;
                break;

            case 9:
                $this->redirectTo = '/dosen';
                return $this->redirectTo;
                break;

            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
        }



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

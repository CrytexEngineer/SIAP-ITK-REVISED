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

    use AuthenticatesUsers {
        username as protected userNip;
        validateLogin as protected userValidation;
        redirectPath as laravelRedirectPath;

    }


    function username()
    {
        return 'PE_Nip';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo;
//    public function redirectTo()
//    {
//        switch (Auth::user()->role) {
//
//            case 1:
//                $this->redirectTo = '/superadmin';
//                return $this->redirectTo;
//                break;
//            case 2:
//                $this->redirectTo = '/admin';
//                return $this->redirectTo;
//                break;
//            case 3:
//                $this->redirectTo = '/observer';
//                return $this->redirectTo;
//                break;
//            case 4:
//                $this->redirectTo = '/warek';
//                return $this->redirectTo;
//                break;
//            case 5:
//                $this->redirectTo = '/kajur';
//                return $this->redirectTo;
//                break;
//            case 6:
//                $this->redirectTo = '/kaprodi';
//                return $this->redirectTo;
//                break;
//
//            case 7:
//                $this->redirectTo = '/dikjur';
//                return $this->redirectTo;
//                break;
//
//            case 8:
//                $this->redirectTo = '/diksat';
//                return $this->redirectTo;
//                break;
//
//            case 9:
//                $this->redirectTo = '/dosen';
//                return $this->redirectTo;
//                break;
//
//            default:
//                $this->redirectTo = '/login';
//                return $this->redirectTo;
//        }
//    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        if(Auth::user()->hasAnyRoles(['Super Admin', 'Admin', 'Observer', 'Wakil Rektor', 'Ketua Prodi', 'Ketua Jurusan', 'Tendik Jurusan', 'Tendik Pusat']))
        {
            $this->redirectTo = route('mahasiswa.index');
            return $this->redirectTo;
        }

        $this->redirectTo = route('jadwal_mengajar');
        return $this->redirectTo;
    }

    public function redirectPath()
    {
        // Do your logic to flash data to session...
        session()->flash('success', 'Anda berhasil login');

        // Return the results of the method we are overriding that we aliased.
        return $this->laravelRedirectPath();
    }
}

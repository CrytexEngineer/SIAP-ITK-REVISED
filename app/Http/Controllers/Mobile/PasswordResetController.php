<?php

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use App\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('resetPassword.success');
    }
    /**
     * Create token password reset
     *
     * @param  [string] MA_Email
     * @return [string] message
     */
    public function create(Request $request)
    {

        $request->validate([
            'MA_Email' => 'required|string',
        ]);

         error_log($request->MA_Email);

        $user = Student::where('email', trim($request['MA_Email'], '"'))->first();

        if (!$user)
            return response()->json([
                'message' => __('passwords.user')
            ], 200);

        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], [
            'email' => $user->email,
            'token' => str_random(60)
        ]);

        if ($user && $passwordReset)
            $user->notify(new PasswordResetRequest($passwordReset->token));

        return response()->json([
            'message' => __('passwords.sent'),
            'user' => [$user]
        ]);
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset)
            return response()->json([
                'message' => __('passwords.token')
            ], 200);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => __('passwords.token')
            ], 200);
        }

        return response()->json($passwordReset);
    }

    /**
     * Reset password
     *
     * @param  [string] MA_Email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $messages = [
//          'email.required' => 'Email tidak boleh kosong.',
//          'email.string' => 'Email hanya boleh diisi dengan huruf.',
//          'email.email' => 'Email yang Anda masukan salah.',
            'password.min' => 'Password minimal 5 karakter.',
            'password.required' => 'Password tidak boleh kosong.',
          'password.string' => 'Password hanya boleh diisi dengan huruf.',
          'password.confirmed' => 'Password yang Anda masukkan tidak sesuai.',
        ];

        $request->validate([
//            'email' => 'required|string|email',
            'password' => 'required|string|min:5|confirmed',
            'token' => 'required|string'
        ],$messages);

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
//            ['email', $request->email]
        ])->first();


            if ($passwordReset == null){
                Session::put('status_failed', 'value');
                return back();

            }



        $user = Student::where('email', $passwordReset->email)->first();

        if (!$user)
            return response()->json([
                'message' => __('passwords.user')
            ], 200);
        $user->MA_PASSWORD = bcrypt( trim($request->password, '"'));
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));
        return view('resetPassword.success');

    }

    public function showForm($token)
    {
//        Session::flash('message', 'This is a message!');
//        Session::flash('alert-class', 'alert-danger');
        return view('resetPassword.index', ["token" => $token]);
    }
}


<?php

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;

class PasswordResetController extends Controller
{
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


        $user = Student::where('email',  trim($request['MA_Email'], '"'))->first();

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
            'user'=>[$user]
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
        $request->validate([
            'MA_Email' => 'required|string|email',
            'MA_PASSWORD' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->MA_Email]
        ])->first();

        if (!$passwordReset)
            return response()->json([
                'message' => __('passwords.token')
            ], 200);

        $user = Student::where('MA_Email', $passwordReset->MA_Email)->first();

        if (!$user)
            return response()->json([
                'message' => __('passwords.user')
            ], 200);

        $user->MA_PASSWORD = bcrypt($request->MA_PASSWORD);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json($user);
    }
}

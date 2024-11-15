<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function signIn(Request $request)
    {
        $validator = Validator::make(
            ['email' => $request->email, 'password' => $request->password],
            ['email' => 'required', 'password' => 'required']
        );

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        } else {
            $auth = (auth()->attempt(['email' => $request->email, 'password' => $request->password]) );

            if ($auth != false) {
                return response()->json([
                    'status'=> 'success',
                    'message' => 'Login successfully'
                ], 200);
            } else {
                return response()->json([
                    'status'=> 'success',
                    'message' => 'Login failed'
                ], 403);
            }
        }
    }

    public function forgetPassword(Request $request)
    {
        return view('auth.forget-password');
    }

    public function passwordForget(Request $request)
    {
        $user = DB::table('users')->where(['email' => $request->email])->first();

        if (!isset($user) && $user == null) {
            return redirect()->back()->withErrors(['email' => 'Entered email address does not exists in records, please check email address']);
        }

        $token = Str::random(60);
        $link = url('/reset-password') . '/' . $token . '?email=' . urlencode($user->email);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $mailData = array('from_email' => _mail_from(), 'email' => $request->email, 'link' => $link);

        try {
            Mail::to($request->email)->send(new ForgetPassword($mailData));

            return redirect()->route('login')->with('success', 'please check your email and follow steps for reset password');
        } catch (\Exception $e) {
            DB::table('password_resets')->where(['email' => $request->email])->delete();
            return redirect()->route('login')->with('error', 'something went wrong, please try again later');
        }
    }

    public function resetPassword(Request $request, $string)
    {
        $email = $request->email;
        return view('auth.reset_password', compact('email', 'string'));
    }

    public function recoverPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $tokenData = DB::table('password_resets')->where('token', $request->token)->OrderBy('created_at', 'desc')->first();

        if (!isset($tokenData) && $tokenData == null)
            return redirect()->route('login')->with('error', 'Reset password token mismatch, Please regenerate link again')->withInput();

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!isset($user) && $user == null)
            return redirect()->back()->with('error', 'Email address does not exists, Please check email address')->withInput();

        $crud = [
            'password' => bcrypt($request->password),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('users')->where('email', $request->email)->limit(1)->update($crud);

        DB::table('password_resets')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('success', 'Password resetted successgully');
    }
}

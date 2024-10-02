<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8',
        ]);


        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();
        session()->flash('success', 'User has been registered');
        return back();
    }

    // public function login()
    // {
    //     return view('auth.login');
    // }
    // public function auth(Request $request)
    // {
    //     $credientials = $request->only('email', 'password');
    //     $authenticated = auth()->attempt($credientials);
    //     if ($authenticated) {
    //         session()->flash('success', 'Login Successful');
    //     } else {
    //         session()->flash('error', 'Invalid Credentials');
    //     }
    //     return back();
    // }
    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout()
    {

        session()->flush();
        auth()->logout();
        return redirect('/login');
    }
    public function forgetPassword()
    {
        return view('auth.forget-password');
    }

    //     public function forgetEmail(Request $request)
    //     {
    //         $validated = $request->validate([
    //             'email' => ['required', 'email', 'exists:users,email']
    //         ]);

    //         $user = User::where('email', $validated['email'])->firstOrFail();
    //         $token = Password::createToken($user);
    //         $mailable = new ResetPasswordMail($user->email, $token);
    //         Mail::to($user)->send($mailable);

    //         session()->flash('success', 'An email with reset link has been sent to you.');
    //         return back();
    //     }

    public function forgetEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email']
        ], [
            'email.exists' => ['Whooops! Looks like you are not registered with us.']
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $token = Password::createToken($user);
        $url = URL::temporarySignedRoute(
            'forget.reset',
            now()->addMinutes(60),
            [
                'email' => $validated['email'],
                'token' => $token
            ]
        );
        $mailable = new ResetPasswordMail($url);
        Mail::to($user)->send($mailable);

        session()->flash('success', 'An email with reset link has been sent to you.');
        return back();
    }

    public function resetPasswordCreate($email, $token)
    {
        return view('auth.reset-password', [
            'email' => $email,
            'token' => $token
        ]);
    }

    public function resetPasswordStore(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::whereEmail($request->email)->first();
        $isValid = Password::tokenExists($user, $request->token);
        if (!$isValid) {
            session()->flash('error', 'Token is invalid. Resend a new link to reset your password.');
            return to_route('forget.request');
        }

        $user->password = Hash::make($request->password);
        $user->update();
        Password::deleteToken($user);
        session()->flash('success', 'Password has been reset.');

        return to_route('login');
    }
}

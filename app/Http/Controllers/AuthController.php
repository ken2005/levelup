<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        
        $credentials = $request->validated();

        //dd($credentials);

        if(Auth::attempt($credentials, $request->remember))
        {
            session()->regenerate();
            $intended = session('url.intended');
            if ($intended && str_contains($intended, '/squad/doAddBro/')) {
                $idBro = explode('/squad/doAddBro/', $intended)[1];
                return redirect()->route('addBro', ['idBro' => $idBro]);
            }
            return redirect()->intended(route('home'));
        }

        return to_route('auth.login')->withErrors([
            'email' => 'Email invalide'
        ])->onlyInput('email');
    }

    public function doSignup(SignupRequest $request)
    {
        $credentials = $request->validated();
        //dd($credentials);
        

        $users = User::where('email', $request->email)->get();

        if(sizeof($users) > 0){
            return 'email déjà utilisé';
        }
        else{

            User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);
            
            if(Auth::attempt($credentials, $request->remember))
            {
                session()->regenerate();
                return redirect()->intended(route('home'));
            }
        }
    }

    
}

/* Kennan */

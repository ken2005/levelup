<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        $user = Auth::user();
        Auth::logout();
        Log::info('Utilisateur déconnecté', ['user_id' => $user->id, 'email' => $user->email]);
        return to_route('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials, $request->remember))
        {
            session()->regenerate();
            Log::info('Utilisateur connecté avec succès', ['email' => $credentials['email']]);
            $intended = session('url.intended');
            if ($intended && str_contains($intended, '/squad/doAddBro/')) {
                $idBro = explode('/squad/doAddBro/', $intended)[1];
                return redirect()->route('addBro', ['idBro' => $idBro]);
            }
            return redirect()->intended(route('home'));
        }

        Log::warning('Echec lors de la connexion', ['email' => $credentials['email']]);
        return to_route('auth.login')->withErrors([
            'email' => 'Email invalide'
        ])->onlyInput('email');
    }

    public function doSignup(SignupRequest $request)
    {
        $credentials = $request->validated();

        $users = User::where('email', $request->email)->get();

        if(sizeof($users) > 0){
            Log::warning('Tentative d\'inscription avec un email existant', ['email' => $credentials['email']]);
            return 'email déjà utilisé';
        }
        else{
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);
            
            Log::info('Nouvel utilisateur inscrit', ['user_id' => $user->id, 'email' => $user->email]);
            
            if(Auth::attempt($credentials, $request->remember))
            {
                session()->regenerate();
                return redirect()->intended(route('home'));
            }
        }
    }
}

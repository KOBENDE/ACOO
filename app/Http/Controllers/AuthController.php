<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function showRegisterForm()
    {
        // $services = Service::all();
        return view(
            'authentification.register'
            // ,compact('services')
        );
    }

    /**
     * Gérer la connexion avec détection du rôle
     */
    // retourne le formulaire de connexion
    public function showLoginForm()
    {
        return view('authentification.login');
    }

    
    // login controller
    // public function login()
    // {
    //     return view('authentificationentification/signin');
    // }

    // // logout controller
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/');
    // }

    // Register controller
    // public function register()
    // {
    //     return view('authentificationentification/signout');
    // }

    // auth_login controller
    // public function auth_login(Request $request)
    // {

    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect('/dashboard');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ])->onlyInput('email');
    // }

    // public function create_user(Request $request)
    // {
    //     // Valider les données du formulaire
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     // Enregistrer l'utilisateur dans la base de données
    //     $user = new User;
    //     $user->name = $validatedData['name'];
    //     $user->email = $validatedData['email'];
    //     $user->password = Hash::make($validatedData['password']);
    //     $user->remember_token = Str::random(40);
    //     $user->save();

    //     Auth::login($user);

    //     // Rediriger l'utilisateur avec un message de succès
    //     return redirect()->route('login')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    // }


    // profile controller
    public function profile()
    {
        return view('profile.index');
    }

    // public function updateProfile(Request $request)
    // {
    //     $user = User::find(Auth::id());

    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //     ]);

    //     $user->name = $validatedData['name'];
    //     $user->email = $validatedData['email'];
    //     $user->save();

    //     return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    // }

    // public function updatePassword(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => 'required',
    //         'new_password' => 'required|string|min:6|confirmed',
    //     ]);

    //     $user = User::find(Auth::id());

    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    //     }

    //     $user->password = Hash::make($request->new_password);
    //     $user->save();

    //     return redirect()->route('profile')->with('success', 'Mot de passe modifié avec succès.');
    // }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreated;
use App\Models\Employe;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Gérer l'inscription des employés (sans vérification du rôle)
     */

    // public function register(Request $request)
    // {
    //     // Validation des données
    //     $validator = $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'prenom' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:employes',
    //         'fonction' => 'nullable|string|max:255',
    //         'service_id' => 'required|exists:services,id',
    //     ]);

    //     // Générer un mot de passe aléatoire
    //     $generatedPassword = Str::random(10);

    //     // Création de l'employé avec le rôle par défaut "employe"
    //     $employe = Employe::create([
    //         'nom' => $request->nom,
    //         'prenom' => $request->prenom,
    //         'email' => $request->email,
    //         'password' => Hash::make($generatedPassword),
    //         'fonction' => $request->fonction,
    //         'service_id' => $request->service_id,
    //         'role' => 'employe', // Toujours "employe" par défaut
    //     ]);

    //     // Envoi du mail avec le mot de passe généré
    //     Mail::to($employe->email)->send(new AccountCreated($employe, $generatedPassword));

    //     return redirect()->route('login.form')->with('success', 'Inscription réussie ! Vérifiez votre e-mail pour récupérer votre mot de passe.');
    // }
    //Affiche le formulaire d'inscription
    public function showRegisterForm()
    {
        // $services = Service::all();
        return view(
            'auth.register'
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

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt($credentials, $request->filled('remember'))) {
    //         $user = Auth::user();

    //         // Redirection selon le rôle
    //         return match ($user->role) {
    //             'directeur' => redirect()->route('directeur.dashboard')->with('success', 'Bienvenue Directeur.'),
    //             'grh' => redirect()->route('grh.dashboard')->with('success', 'Bienvenue Gestionnaire RH.'),
    //             'chef_service' => redirect()->route('chef.dashboard')->with('success', 'Bienvenue Chef de Service.'),
    //             default => redirect()->route('employe.dashboard')->with('success', 'Bienvenue Employé.'),
    //         };
    //     }

    //     return back()->withErrors(['email' => 'Les informations d’identification ne correspondent pas.'])->withInput();
    // }
    // //Pour la deconnexion 
    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect()->route('login.form')->with('success', 'Vous avez été déconnecté.');
    // }




    // fonction pour le mot de passe
    // public function showChangePasswordForm()
    // {
    //     return view('authentification.change-password');
    // }
    // Modification du mot de passe
    //Retourne le formulaire d'oublie du mot de passe  
    // public function showForgotPasswordForm()
    // {
    //     return view('authentification.forgot-password');
    // }

    // //Envoie du mail pour la reinitialisation du mot de passe
    // public function sendResetLink(Request $request)
    // {
    //     $request->validate(['email' => 'required|email|exists:employes,email']);

    //     $status = Password::sendResetLink($request->only('email'));

    //     return $status === Password::RESET_LINK_SENT
    //         ? back()->with(['success' => 'Un lien de réinitialisation a été envoyé à votre adresse email.'])
    //         : back()->withErrors(['email' => 'Impossible d’envoyer l’email de réinitialisation.']);
    // }
    //Retourne le formulaire de reinitialisation
    //     public function showResetForm($token)
    //     {
    //         return view('authentification.reset-password', compact('token'));
    //     }

    //     //Permet de mettre a jour le mot de passe 
    //     public function resetPassword(Request $request)
    //     {
    //         $request->validate([
    //             'email' => 'required|email|exists:employes,email',
    //             'password' => 'required|string|min:8|confirmed',
    //             'token' => 'required'
    //         ]);

    //         $status = Password::reset(
    //             $request->only('email', 'password', 'password_confirmation', 'token'),
    //             function ($employe, $password) {
    //                 $employe->password = Hash::make($password);
    //                 $employe->save();
    //             }
    //         );

    //         return $status === Password::PASSWORD_RESET
    //             ? redirect()->route('login.form')->with('success', 'Votre mot de passe a été réinitialisé avec succès.')
    //             : back()->withErrors(['email' => 'Le lien de réinitialisation est invalide ou expiré.']);
    // }
}

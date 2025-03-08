<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{


    public function showRegisterForm()
    {
        $services = Service::all();
        return view(
            'authentification.register',
            compact('services')
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

    public function LoginValidation(Request $request)
    {
        // Valider les données du formulaire
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérifier si l'utilisateur a coché "Se souvenir de moi"
        $remember = $request->has('remember'); // Retourne true si coché, false sinon

        // Tenter d'authentifier l'utilisateur avec l'option "remember"
        if (Auth::attempt($credentials, $remember)) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Rediriger en fonction du rôle de l'utilisateur
            switch ($user->role) {
                case 'directeur':
                    return redirect()->route('directeur.dashboard');
                case 'grh':
                    return redirect()->route('directeur.dashboard');
                case 'chef_service':
                    return redirect()->route('directeur.dashboard');
                case 'employe':
                default:
                    return redirect()->route('directeur.dashboard');
            }
        }

        // Si l'authentification échoue, rediriger avec un message d'erreur
        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ])->onlyInput('email');
    }

    // Afficher le formulaire de demande de réinitialisation
    public function showForgotPasswordForm()
    {
        return view('authentification.forgot-password');
    }

    // Envoyer l'email avec le lien de réinitialisation
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:employes,email']);

        // Envoi du lien de réinitialisation
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Afficher le formulaire de réinitialisation de mot de passe
    public function showResetForm($token)
    {
        return view('authentification.reset-password', ['token' => $token]);
    }

    // Réinitialiser le mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employes,email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                Auth::login($user); // Connexion automatique après reset
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }



    // login controller
    // public function login()
    // {
    //     return view('authentificationentification/signin');
    // }

    // // logout controller
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    // Register controller
    public function register(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employes', // Utilisez 'employes' au lieu de 'users'
            'fonction' => 'required|string|max:255',
            'role' => 'nullable|in:employe,chef_service,grh,directeur', // Validation pour le champ enum
            'service_id' => 'required|exists:services,id', // Validation pour la clé étrangère
        ]);
        // // Génère un mot de passe de 8 caractères
        $password = Str::random(8);
        // Enregistrer l'employé dans la base de données
        $employe = new Employe;
        $employe->nom = $validatedData['nom'];
        $employe->prenom = $validatedData['prenom'];
        $employe->email = $validatedData['email'];
        $employe->password = Hash::make($password); // Hasher le mot de passe
        $employe->fonction = $validatedData['fonction'];
        $employe->role = $validatedData['role'] ?? 'employe'; // Valeur par défaut si non fournie
        $employe->service_id = $validatedData['service_id'];
        $employe->save();

        // Envoyer un e-mail à l'employé avec ses informations de connexion
        Mail::to($employe->email)->send(new AccountCreated($employe, $password));
        // Connecter l'employé après l'inscription (optionnel)
        //Auth::login($employe);

        // Rediriger l'employé avec un message de succès
        return redirect()->route('login.form')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }

    // profile controller
    public function profile()
    {
        return view('profile.index');
    }

    public function updateProfile(Request $request)
    {
        $user = Employe::find(Auth::id());

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employes,email,' . $user->id,
        ]);
        
        $user->nom = $validatedData['nom'];
        $user->email = $validatedData['email'];
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Employe::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Mot de passe modifié avec succès.');
    }
}

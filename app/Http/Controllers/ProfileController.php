<?php

namespace App\Http\Controllers;
use App\Models\Employe;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
 // fonction pour afficher le profil
 public function profile(){
      $services = Service::all();
        return view('authentification.profile', compact('services'));
    }

    //fonction pour la mise en jour 
    public function updatedProfile($request){
         $user = Employe::find(Auth::id());
       
    // Validation des champs
    $request->validate([
        'email' => 'required|email|unique:employes,email,' . $user->id,
        'service_id' => 'required|exists:services,id',
        'fonction' => 'nullable|string|max:255',
    ]);

    // Mise à jour des informations
    $user->email = $request->email;
    $user->service_id = $request->service_id;
    $user->fonction = $request->fonction;
    $user->save();

    return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
    public function updatePassword(Request $request){
         // Validation des champs
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $user = Employe::find(Auth::id());

    // Vérification du mot de passe actuel
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    // Mise à jour du mot de passe
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
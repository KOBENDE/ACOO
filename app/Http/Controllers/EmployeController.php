<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $user = Auth::user(); // Récupérer l'utilisateur connecté

    // Vérifier son rôle et récupérer les employés en conséquence
    if ($user->isDirecteur()) {
        // Le directeur voit tous les employés (y compris les chefs de service et le GRH)
        $employes = Employe::where('role', '!=', 'directeur')->get();
    } elseif ($user->isGRH()) {
        // Le GRH voit tous les employés sauf le directeur
        $employes = Employe::where('id', '!=', $user->id)->get();
    } elseif ($user->isChefService()) {
        // Un chef de service ne voit que les employés de son service (sauf lui-même, les autres chefs et le directeur)
        $employes = Employe::where('service_id', $user->service_id)
                            ->whereNotIn('role', ['chef_service', 'directeur'])
                            ->where('id', '!=', $user->id)
                            ->get();
    } else {
        // Un employé simple ne devrait pas accéder à cette page
        abort(403, 'Accès non autorisé');
    }

    return view('employes.listes.index', compact('employes'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employe $employe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employe $employe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employe $employe)
    {
        //
    }
}
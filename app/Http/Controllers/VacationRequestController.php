<?php

namespace App\Http\Controllers;

use App\Models\VacationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VacationRequestController extends Controller
{
    public function index(): View
    {
        $conges = VacationRequest::latest()->paginate(10);
        return view('employes/conges.index', compact('conges'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        return view('employes/conges.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string',
            'type' => 'required|string',
            'statut' => 'required|string'
        ]);

        // Calculer la durée en jours entre date_debut et date_fin
        $debut = \Carbon\Carbon::parse($request->date_debut);
        $fin = \Carbon\Carbon::parse($request->date_fin);
        $duree = $debut->diffInDays($fin) + 1; // +1 pour inclure le jour de début

        // Créer le conge avec la durée calculée
        VacationRequest::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'duree' => $duree,
            'motif' => $request->motif,
            'type' => $request->type,
            'statut' => $request->statut
        ]);

        return redirect()->route('conges.index')
            ->with('success', 'Demande de congé créée avec succès.');
    }

    public function show(VacationRequest $conge): View
    {
        return view('employes/conges.show', compact('conge'));
    }

    public function edit(VacationRequest $conge): View
    {
        return view('employes/conges.edit', compact('conge'));
    }

    public function update(Request $request, VacationRequest $conge): RedirectResponse
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string',
            'type' => 'required|string',
            'statut' => 'required|string'
        ]);

        // Recalculer la durée
        $debut = \Carbon\Carbon::parse($request->date_debut);
        $fin = \Carbon\Carbon::parse($request->date_fin);
        $duree = $debut->diffInDays($fin) + 1;

        $conge->update([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'duree' => $duree,
            'motif' => $request->motif,
            'type' => $request->type,
            'statut' => $request->statut
        ]);

        return redirect()->route('conges.index')
            ->with('success', 'Demande de congé mise à jour avec succès.');
    }

    public function destroy(VacationRequest $conge): RedirectResponse
    {
        $conge->delete();
        return redirect()->route('conges.index')
            ->with('success', 'Demande de congé supprimée avec succès.');
    }
}


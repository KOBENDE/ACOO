<?php

namespace App\Http\Controllers;

use App\Models\AbsenceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AbsenceRequestController extends Controller
{
    public function index(): View
    {
        $absences = AbsenceRequest::latest()->paginate(10);
        return view('employes/absences.index', compact('absences'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        return view('employes/absences.create');
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

        // Créer l'absence avec la durée calculée
        AbsenceRequest::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'duree' => $duree,
            'motif' => $request->motif,
            'type' => $request->type,
            'statut' => $request->statut
        ]);

        return redirect()->route('absences.index')
            ->with('success', 'Demande d\'absence créée avec succès.');
    }

    public function show(AbsenceRequest $absence): View
    {
        return view('employes/absences.show', compact('absence'));
    }

    public function edit(AbsenceRequest $absence): View
    {
        return view('employes/absences.edit', compact('absence'));
    }

    public function update(Request $request, AbsenceRequest $absence): RedirectResponse
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

        $absence->update([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'duree' => $duree,
            'motif' => $request->motif,
            'type' => $request->type,
            'statut' => $request->statut
        ]);

        return redirect()->route('absences.index')
            ->with('success', 'Demande d\'absence mise à jour avec succès.');
    }

    public function destroy(AbsenceRequest $absence): RedirectResponse
    {
        $absence->delete();
        return redirect()->route('absences.index')
            ->with('success', 'Demande d\'absence supprimée avec succès.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\AbsenceRequest;
use App\Models\Employe;
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

    public function create(): View|RedirectResponse
    {
        $employe = auth()->user();

        // Vérifier si l'employé peut faire une demande
        if (!$employe->peutFaireDemande()) {
            return redirect()->route('directeur.dashboard')
                ->with('error', 'Votre quota de demandes est épuisé. Vous pourrez faire de nouvelles demandes après un an.');
        }

        return view('employes/absences.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $employe = auth()->user();

        // Vérifier à nouveau si l'employé peut faire une demande
        if (!$employe->peutFaireDemande()) {
            return redirect()->route('directeur.dashboard')
                ->with('error', 'Votre quota de demandes est épuisé. Vous pourrez faire de nouvelles demandes après un an.');
        }

        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string',
            'type' => 'required|string',
            'statut' => 'required|string'
        ]);

        $debut = \Carbon\Carbon::parse($request->date_debut);
        $fin = \Carbon\Carbon::parse($request->date_fin);
        $duree = $debut->diffInDays($fin) + 1;

        AbsenceRequest::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'duree' => $duree,
            'motif' => $request->motif,
            'type' => $request->type,
            'statut' => $request->statut,
            'employe_id' => $employe->id
        ]);

        // Diminuer le quota de l'employé
        $employe->diminuerQuota();

        $admins = Employe::whereIn('role', ['chef_service', 'grh', 'directeur'])->get();
        foreach ($admins as $admin) {
            $admin->increment('pending_requests');
        }

        return redirect()->route('absences.index')
            ->with('success', 'Demande d\'absence créée avec succès.');
    }

    public function show(AbsenceRequest $absence): View
    {
        return view('employes/absences.show', compact('absence'));
    }

    public function edit(AbsenceRequest $absence): View
    {

        $dateFormats = [
            'date_debut' => $absence->date_debut->format('Y-m-d'),
            'date_fin' => $absence->date_fin->format('Y-m-d')
        ];

        return view('employes/absences.edit', compact('absence', 'dateFormats'));
    }

    public function update(Request $request, AbsenceRequest $absence): RedirectResponse
    {
        // Vérifier si l'absence est déjà au statut "Demandée"
        if ($absence->statut == 'Demandée') {
            return redirect()->route('absences.index')
                ->with('error', 'Les absences au statut "Demandée" ne peuvent pas être modifiées.');
        }

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

    public function approuver(AbsenceRequest $absence): RedirectResponse
    {
        $currentUser = auth()->user();
        $employeDemandeService = $absence->employe->service_id;

        if (($currentUser->is_admin == 1 || $currentUser->is_admin == 2) &&
            $currentUser->service_id == $employeDemandeService
        ) {

            $absence->update([
                'statut' => 'Acceptée'
            ]);

            $employe = $absence->employe;
            $employe->increment('has_response');

            return redirect()->route('absences.index')
                ->with('success', 'Demande d\'absence acceptée avec succès.');
        }

        return redirect()->route('absences.index')
            ->with('error', 'Vous n\'êtes pas autorisé à approuver cette demande.');
    }

    public function rejeter(AbsenceRequest $absence): RedirectResponse
    {
        $currentUser = auth()->user();
        $employeDemandeService = $absence->employe->service_id;

        if (($currentUser->is_admin == 1 || $currentUser->is_admin == 2) &&
            $currentUser->service_id == $employeDemandeService
        ) {

            $absence->update([
                'statut' => 'Rejetée'
            ]);

            $employe = $absence->employe;
            $employe->increment('has_response');

            return redirect()->route('absences.index')
                ->with('success', 'Demande d\'absence rejetée avec succès.');
        }

        return redirect()->route('absences.index')
            ->with('error', 'Vous n\'êtes pas autorisé à rejeter cette demande.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Employe;
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

    public function dashboard()
    {
        $conges = VacationRequest::with('employe')
            ->latest()
            ->take(2)
            ->get();

        return view('dashboard/dashboardAdmin/index', compact('conges'));
    }

    public function create(): View|RedirectResponse
    {
        $employe = auth()->user();

        // Vérifier si l'employé peut faire une demande
        if (!$employe->peutFaireDemande()) {
            return redirect()->route('directeur.dashboard')
                ->with('error', 'Votre quota de demandes est épuisé. Vous pourrez faire de nouvelles demandes après un an.');
        }

        return view('employes/conges.create');
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

        VacationRequest::create([
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

        return redirect()->route('conges.index')
            ->with('success', 'Demande de congé créée avec succès.');
    }

    public function show(VacationRequest $conge): View
    {
        return view('employes/conges.show', compact('conge'));
    }

    public function edit(VacationRequest $conge): View
    {
        $dateFormats = [
            'date_debut' => $conge->date_debut->format('Y-m-d'),
            'date_fin' => $conge->date_fin->format('Y-m-d')
        ];

        return view('employes/conges.edit', compact('conge', 'dateFormats'));
    }

    public function update(Request $request, VacationRequest $conge): RedirectResponse
    {
        // Vérifier si le congé est déjà au statut "Demandée"
        if ($conge->statut == 'Demandée') {
            return redirect()->route('conges.index')
                ->with('error', 'Les congés au statut "Demandée" ne peuvent pas être modifiées.');
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

    public function approuver(VacationRequest $conge): RedirectResponse
    {
        $currentUser = auth()->user();
        $employeDemandeService = $conge->employe->service_id;

        if (($currentUser->is_admin == 1 || $currentUser->is_admin == 2) &&
            $currentUser->service_id == $employeDemandeService
        ) {

            $conge->update([
                'statut' => 'Acceptée'
            ]);

            $employe = $conge->employe;
            $employe->increment('has_response');

            return redirect()->route('conges.index')
                ->with('success', 'Demande de congé acceptée avec succès.');
        }

        return redirect()->route('conges.index')
            ->with('error', 'Vous n\'êtes pas autorisé à approuver cette demande.');
    }

    public function rejeter(VacationRequest $conge): RedirectResponse
    {
        $currentUser = auth()->user();
        $employeDemandeService = $conge->employe->service_id;

        if (($currentUser->is_admin == 1 || $currentUser->is_admin == 2) &&
            $currentUser->service_id == $employeDemandeService
        ) {

            $conge->update([
                'statut' => 'Rejetée'
            ]);

            $employe = $conge->employe;
            $employe->increment('has_response');

            return redirect()->route('conges.index')
                ->with('success', 'Demande de congé rejetée avec succès.');
        }

        return redirect()->route('conges.index')
            ->with('error', 'Vous n\'êtes pas autorisé à rejeter cette demande.');
    }
}

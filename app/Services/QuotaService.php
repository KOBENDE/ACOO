<?php

namespace App\Services;

use App\Models\Employe;
use Carbon\Carbon;

class QuotaService
{
    public function reinitialiserQuotasAnnuels()
    {
        // Trouver les employés dont le quota doit être réinitialisé
        $employes = Employe::where('quota_demandes', 0)
            ->whereDate('derniere_reinitialisation_quota', '<=', Carbon::now()->subYear())
            ->get();
            
        foreach ($employes as $employe) {
            $employe->quota_demandes = 5;
            $employe->derniere_reinitialisation_quota = now();
            $employe->save();
        }
        
        return count($employes);
    }
}
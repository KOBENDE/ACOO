<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Employe extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'fonction',
        'role',
        'service_id',
        'quota_demandes',
        'derniere_reinitialisation_quota'
    ];

    // Relations existantes
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Vérification des rôles
    public function isGRH()
    {
        return $this->role === 'grh';
    }
    public function isChefService()
    {
        return $this->role === 'chef_service';
    }
    public function isDirecteur()
    {
        return $this->role === 'directeur';
    }
    public function isEmploye()
    {
        return $this->role === 'employe';
    }

    // Méthode pour vérifier si l'employé peut faire une demande
    public function peutFaireDemande(): bool
    {
        // Vérifier si le quota est épuisé
        if ($this->quota_demandes <= 0) {
            // Vérifier si un an s'est écoulé depuis la dernière réinitialisation
            $derniere_reinit = new Carbon($this->derniere_reinitialisation_quota);
            $un_an_apres = $derniere_reinit->addYear();

            if (now()->gte($un_an_apres)) {
                // Réinitialiser le quota
                $this->quota_demandes = 5;
                $this->derniere_reinitialisation_quota = now();
                $this->save();
                return true;
            }
            return false;
        }
        return true;
    }

    // Méthode pour diminuer le quota après une demande réussie
    public function diminuerQuota(): void
    {
        if ($this->quota_demandes > 0) {
            $this->quota_demandes--;
            $this->save();
        }
    }

    // Relations avec les demandes
    public function absenceRequests()
    {
        return $this->hasMany(AbsenceRequest::class);
    }

    public function vacationRequests()
    {
        return $this->hasMany(VacationRequest::class);
    }
}

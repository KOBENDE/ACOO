<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Employe extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nom', 'prenom', 'email', 'password', 'fonction', 'role', 'service_id'];

    // Un employé appartient à un service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Vérification des rôles
    public function isGRH() { return $this->role === 'grh'; }
    public function isChefService() { return $this->role === 'chef_service'; }
    public function isDirecteur() { return $this->role === 'directeur'; }
    public function isEmploye() { return $this->role === 'employe'; }
}
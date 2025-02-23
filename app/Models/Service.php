<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
use HasFactory;

protected $fillable = ['nom', 'chef_service_id'];

// Un service peut avoir plusieurs employés
public function employes(): HasMany
{
return $this->hasMany(Employe::class);
}

// Un service a un seul chef de service
public function chefService(): HasOne
{
return $this->hasOne(SuperieurHierarchique::class, 'id', localKey: 'chef_service_id');
}
}
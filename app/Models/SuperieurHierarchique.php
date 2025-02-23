<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuperieurHierarchique extends Model
{
use HasFactory;

protected $fillable = ['nom', 'prenom', 'service_id', 'employe_id'];

// Un chef de service est lié à un service
public function service(): BelongsTo
{
return $this->belongsTo(Service::class);
}

// Un chef de service est aussi un employé
public function employe(): BelongsTo
{
return $this->belongsTo(Employe::class, 'employe_id');
}
}
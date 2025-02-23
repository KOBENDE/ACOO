<?php
    
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directeur extends Model
{
use HasFactory;

protected $fillable = ['nom', 'prenom', 'employe_id'];

// Le directeur est aussi un employé
public function employe(): BelongsTo
{
return $this->belongsTo(Employe::class, 'employe_id');
}
}
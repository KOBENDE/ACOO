<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut',
        'date_fin',
        'duree',
        'motif',
        'type',
        'statut'
    ];

    protected $dates = ['date_debut', 'date_fin'];
    
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];
}
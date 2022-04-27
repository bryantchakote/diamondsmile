<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    public $fillable = [
        'id_patient',
        'assurance',
        'matricule',
        'employeur',
        'taux_couvert',
        'valeur_D',
        'valeur_SC'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }
}

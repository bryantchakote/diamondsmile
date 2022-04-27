<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;

    public $fillable = [
        'date',
        'derniere_visite',
        'id_patient',
        'motif',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }
    
    public function operations()
    {
        return $this->hasMany(Operation::class, 'id_visite');
    }
    
    public function consultation()
    {
        return $this->hasOne(Consultation::class, 'id_visite');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'id_visite');
    }

    public function factures()
    {
        return $this->hasMany(Facture::class, 'id_visite');
    }
}

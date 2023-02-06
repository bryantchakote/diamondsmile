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

    public function supprimer($x) {
        $id_patient = $this->patient->id;

        $ops = $this->operations;
        if (count($ops) > 0) {
            foreach ($ops as $op) {
                Operation::find($op->id)->delete();
            }
        }
        
        $prescs = $this->prescriptions;
        if (count($prescs) > 0) {
            foreach ($prescs as $presc) {
                Prescription::find($presc->id)->delete();
            }
        }
        
        $factures = Facture::where('id_visite', $this->id)->get();
        if (count($factures) > 0) {
            foreach ($factures as $facture) {
                $facture = Facture::find($facture->id);
                $reglements = $facture->reglements;

                if (count($reglements) > 0) {
                    foreach ($reglements as $reglement) {
                        Reglement::find($reglement->id)->delete();
                    }
                }

                $facture->delete();
            }
        }

        $this->delete();

        if ($x == 0) redirect('patient/' . $id_patient);
    }
}

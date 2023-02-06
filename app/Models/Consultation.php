<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    public $fillable = [
        'medocs_en_cours',
        'observations',
        'frais',
        'id_visite',
    ];

    public function visite()
    {
        return $this->belongsTo(Visite::class, 'id_visite');
    }

    public function exams()
    {
        return $this->hasMany(Examen::class, 'id_cons');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'id_cons');
    }

    public function supprimer($x) {
        $cons = Consultation::find($this->id);
        $id_patient = $this->visite->patient->id;
        
        $exams = $cons->exams;
        if (count($exams) > 0) {
            foreach ($exams as $exam) {
                Examen::find($exam->id)->delete();
            }
        }
        
        $prescs = $cons->visite->prescriptions;
        if (count($prescs) > 0) {
            foreach ($prescs as $presc) {
                Prescription::find($presc->id)->delete();
            }
        }
        
        $plans = $cons->plans;
        if (count($plans) > 0) {
            foreach ($plans as $plan) {
                $plan = Plan::find($plan->id);
                $operations = $plan->operations;

                if (count($operations) > 0) {
                    foreach ($operations as $operation) {
                        Operation::find($operation->id)->delete();
                    }
                }

                $plan->delete();
            }
        }

        $factures = Facture::where('id_visite', $cons->visite->id)->get();
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

        $cons->visite->delete();
        $cons->delete();

        if ($x == 0) redirect('patient/' . $id_patient);
    }
}

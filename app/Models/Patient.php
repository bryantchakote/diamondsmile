<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    public $fillable = [
        'nom',
        'sexe',
        'date_nais',
        'lieu_nais',
        'adresse',
        'tel',
        'email',
        'profession',
        'referant',
        'tel_referant',
    ];

    public function rdvs()
    {
        return $this->hasMany(Rdv::class, 'id_patient');
    }

    public function etats()
    {
        return $this->hasMany(Etat::class, 'id_patient');
    }
    
    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'id_patient');
    }
    
    public function visites()
    {
        return $this->hasMany(Visite::class, 'id_patient');
    }

    public function age()
    {
        $naissance = Carbon::parse($this->date_nais);
        $aujd = now();
        return $naissance->diffInYears($aujd);
    }

    public function assure()
    {
        return is_null($this->contrats->last()->assurance) ? 0 : 1;
    }

    public function depense()
    {
        $depense = 0;
        $visites = Patient::find($this->id)->visites;

        foreach ($visites as $visite) {
            $factures = $visite->factures;
            if (count($factures) > 0) {
                foreach ($factures as $facture) {
                    $reglements = $facture->reglements;

                    foreach ($reglements as $reglement) {
                        $depense += $reglement->montant;
                    }
                }
            }
        }

        return(number_format($depense, 0, '', ' '));
    }

    public function dette()
    {
        $dette = 0;
        $visites = Patient::find($this->id)->visites;

        foreach ($visites as $visite) {
            $factures = $visite->factures;
            if (count($factures) > 0) {
                foreach ($factures as $facture) {
                    $regle = 0;
                    $NAP = round($facture->total * (1 - $facture->remise / 100));
                    $reglements = $facture->reglements;

                    foreach ($reglements as $reglement) {
                        $regle += $reglement->montant;
                    }
                    $dette += $NAP - $regle;
                }
            }
        }

        return(number_format($dette, 0, '', ' '));
    }

    public function supprimer() {
        $visites = Patient::find($this->id)->visites;

        if (count($visites) > 0) {
            foreach ($visites as $visite) {
                if ($visite->motif == "consultation") {
                    $visite->consultation->supprimer(1);
                } elseif ($visite->motif == "traitement") {
                    $visite->supprimer(1);
                }
            }
        }

        $rdvs = $this->rdvs;
        if (count($rdvs) > 0) {
            foreach ($rdvs as $rdv) {
                Rdv::find($rdv->id)->delete();
            }
        }
        
        $etats = $this->etats;
        if (count($etats) > 0) {
            foreach ($etats as $etat) {
                Etat::find($etat->id)->delete();
            }
        }
        
        $contrats = $this->contrats;
        if (count($contrats) > 0) {
            foreach ($contrats as $contrat) {
                Contrat::find($contrat->id)->delete();
            }
        }

        $this->delete();

        return route('patients');
    }
}

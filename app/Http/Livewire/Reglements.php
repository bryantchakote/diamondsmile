<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reglement;
use App\Models\Visite;
use App\Models\Facture;
use App\Models\Patient;

class Reglements extends Component
{
    public $id_patient = '';
    public $factures = '';
    public $reglements = [
        'assur' => [],
        'patient' => [],
    ];

    public function mount($patientId) {
        $this->id_patient = $patientId;
        $id_visites = Visite::orderBy('date')->where('id_patient', $this->id_patient)->get('id');
        $this->factures = Facture::whereIn('id_visite', $id_visites)->where(function ($query) {
            return $query->where('reglee_assureur', 0)->orWhere('reglee_assure', 0);
        })->get();

        for ($i = 0; $i < $this->factures->count(); $i++) {
            array_push($this->reglements['assur'], 0);
            array_push($this->reglements['patient'], 0);
        }
    }

    public function validerReglement($factureId) {
        $facture = Facture::find($factureId);
        $patient = $facture->visite->patient;

        $NAP = round($facture->total * (1 - $facture->remise / 100));
        $NAP_assureur = round($NAP * $patient->contrats->last()->taux_couvert / 100);
        $NAP_patient = $NAP - $NAP_assureur;
        $regle = 0;
        $regle_assureur = 0;
        $regle_patient = 0;
        $reglements = $facture->reglements;

        if ($reglements->count() > 0) {
            foreach ($reglements as $reglement) {
                $regle += $reglement->montant;
                            
                if ($reglement->auteur == 'assureur') {
                    $regle_assureur += $reglement->montant;
                } elseif ($reglement->auteur == 'assure') {
                    $regle_patient += $reglement->montant;
                }
            }
        }

        $factures = [];

        foreach($this->factures as $fac) {
            array_push($factures, $fac->id);
        }

        $index = array_search($factureId, $factures);

        if (0 < $this->reglements['assur'][$index] && $this->reglements['assur'][$index] <= ($NAP_assureur - $regle_assureur)) {
            Reglement::create([
                'date' => now(),
                'auteur' => 'assureur',
                'montant' => $this->reglements['assur'][$index],
                'id_facture' => $facture->id,
            ]);

            if ($this->reglements['assur'][$index] == ($NAP_assureur - $regle_assureur)) {
                Facture::find($factureId)->update([
                    'reglee_assureur' => 1,
                ]);
            }

            session()->flash('valide', 'Validé');
        }

        if (0 < $this->reglements['patient'][$index] && $this->reglements['patient'][$index] <= ($NAP_patient - $regle_patient)) {
            Reglement::create([
                'date' => now(),
                'auteur' => 'assure',
                'montant' => $this->reglements['patient'][$index],
                'id_facture' => $facture->id,
            ]);

            if ($this->reglements['patient'][$index] == ($NAP_patient - $regle_patient)) {
                Facture::find($factureId)->update([
                    'reglee_assure' => 1,
                ]);
            }
        }  

        $this->reglements['assur'][$index] = 0;
        $this->reglements['patient'][$index] = 0;
        $this->mount($this->id_patient);
    }

    public function render()
    {
        return view('livewire.reglements', [
            'patient' => Patient::find($this->id_patient),
        ]);
    }
}

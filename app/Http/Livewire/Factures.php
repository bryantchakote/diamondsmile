<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Facture;
use App\Models\Reglement;
use App\Models\Plan;
use App\Models\Visite;
use App\Models\Consultation;
use App\Models\Traitement;
use App\Models\Prescription;

class Factures extends Component
{
    public $id_facture = '';
    public $id_visite = '';
    public $id_cons = '';
    public $total = 0;
    public $remise = 0;

    public function mount($factureId)
    {
        $this->id_facture = $factureId;
        $this->id_visite = Visite::orderByDesc('updated_at')->get()[0]->id;
        $this->id_cons = (Visite::find($this->id_visite)->consultation->count() == 0) ? '' : Visite::find($this->id_visite)->consultation->id;

        $factures = Visite::find($this->id_visite)->factures;
        if (count($factures) > 0) {
            foreach ($factures as $facture) {
                $reglements = $facture->reglements;

                if (count($reglements) > 0) {
                    foreach ($reglements as $reglement) {
                        Reglement::find($reglement->id)->delete();
                    }
                }

                Facture::find($facture->id)->delete();
            }
        }
    }

    public function ajouterFacture()
    {
        $this->total += ($this->id_cons != '') ? Consultation::find($this->id_cons)->frais : 0;

        $plans = ($this->id_cons != '') ? (Plan::where('id_cons', $this->id_cons)->where('confirme', 1)->get() ?? '') : '';

        if ($plans != '') {
            foreach ($plans as $plan) {
                $this->total += $plan->prix;
            }
        }

        Facture::create([
            'total' => $this->total,
            'remise' => $this->remise,
            'reglee_assureur' => (Visite::find($this->id_visite)->patient->contrats->last()->taux_couvert == 0) ? 1 : 0,
            'reglee_assure' => 0,
            'id_visite' => $this->id_visite,
        ]);

        if (Prescription::where('id_visite', $this->id_visite)->count() > 0) {
            redirect('../../ordonnance/' . $this->id_visite);
        } else {
            redirect('patient/' . Visite::find($this->id_visite)->patient->id);
        }
            
    }

    public function render()
    {
        return view('livewire.factures', [
            'date' => date('d F Y', strtotime(Visite::find($this->id_visite)->date)),
            'frais_cons' => ($this->id_cons != '') ? Consultation::find($this->id_cons)->frais : '',
            'plans' => ($this->id_cons != '') ? Plan::where('id_cons', $this->id_cons)->where('confirme', 1)->get() : '',
            'patient' => Visite::find($this->id_visite)->patient,
        ]);
    }
}

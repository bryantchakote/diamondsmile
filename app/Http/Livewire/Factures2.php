<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Facture;
use App\Models\Plan;
use App\Models\Visite;
use App\Models\Consultation;
use App\Models\Traitement;
use App\Models\Prescription;

class Factures2 extends Component
{
    public $id_facture = '';
    public $id_visite = '';
    public $total = 0;
    public $remise = 0;
    public $plans = [];

    public function mount($factureId)
    {
        $this->id_facture = $factureId;
        $this->total = Facture::find($this->id_facture)->total;
        $this->id_visite = Visite::latest('updated_at')->get()[0]->id;

        $plans = Plan::orderByDesc('updated_at')->get();
        $prix = 0;

        foreach ($plans as $plan) {
            if (round($prix) != round($this->total)) {
                array_push($this->plans, $plan->id);
            } else {
                return;
            }

            $prix += $plan->prix;
        }
    }

    public function validerFacture()
    {
        Facture::find($this->id_facture)->update([
            'remise' => $this->remise,
        ]);

        if (Prescription::where('id_visite', $this->id_visite)->count() > 0) {
            redirect('../../ordonnance/' . $this->id_visite);    
        } else {
            redirect('patient/' . Visite::find($this->id_visite)->patient->id);
        }
        
    }
    

    public function render()
    {
        return view('livewire.factures2', [
            'facture' => Facture::find($this->id_facture),
            'patient' => Facture::find($this->id_facture)->visite->patient,
            'date' => Facture::find($this->id_facture)->visite->date,
        ]);
    }
}

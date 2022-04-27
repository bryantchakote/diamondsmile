<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Prescription;
use App\Models\Visite;

class Prescriptions extends Component
{
    public $id_visite = '';
    public $n_produit = '';
    public $n_mode_emploi = '';
    public $m_presc = '';
    public $m_produit = '';
    public $m_mode_emploi = '';
    public $mode_presc = 'ajout';

    public function mount($visiteId)
    {
        $this->id_visite = Visite::find($visiteId)->id;
    }

    public function ajouterPresc()
    {
        if ($this->n_produit != '') {
            Prescription::create([
                'produit' => $this->n_produit,
                'mode_emploi' => ($this->n_mode_emploi != '') ? $this->n_mode_emploi : null,
                'id_visite' => $this->id_visite,
            ]);

            $this->n_produit = '';
            $this->n_mode_emploi = '';
        }
    }

    public function modeModifPresc($prescId)
    {
        $this->mode_presc = 'modif';

        $this->m_presc = Prescription::find($prescId);

        $this->m_produit = $this->m_presc->produit;
        $this->m_mode_emploi = $this->m_presc->mode_emploi ?? '';
    }

    public function modeAjoutPresc()
    {
        $this->mode_presc = 'ajout';
    }

    public function modifierPresc()
    {
        if ($this->m_produit != $this->m_presc->produit || $this->m_mode_emploi != $this->m_presc->mode_emploi) {
            $this->m_presc->update([
                'produit' => $this->m_produit,
                'mode_emploi' => ($this->m_mode_emploi != '') ? $this->m_mode_emploi : null,
            ]);

            $this->modeAjoutPresc();
        }
    }

    public function supprimerPresc($prescId)
    {
        Prescription::find($prescId)->delete();
    }

    public function render()
    {
        return view('livewire.prescriptions', [
            'prescs' => Prescription::where('id_visite', $this->id_visite)->get(),
        ]);
    }
}

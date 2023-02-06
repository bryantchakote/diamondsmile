<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Antecedent;
use App\Models\Etat;
use App\Models\Consultation;

class DossierPatient extends Component
{
    public $etats_selectionnes = [];
    public $etats_selectionnes_sm = [];
    public $commentaire = '';
    public $choix_action = 'dossier';
    public $id_patient;
    
    public function mount($patientId)
    {
        $this->id_patient = $patientId;

        $this->commentaire = Etat::where('id_patient', Patient::find($this->id_patient)->id)->where('id_antecedent', 28)->get('commentaire')[0]->commentaire ?? '';

        for ($i = 0; $i < Antecedent::count() - 1; $i++) {
            (Etat::where('id_patient', $this->id_patient)->where('id_antecedent', $i + 1)->count() == 0) ? array_push($this->etats_selectionnes, 0) : array_push($this->etats_selectionnes, 1);
        }

        for ($i = 0; $i < Antecedent::count() - 1; $i++) {
            (Etat::where('id_patient', $this->id_patient)->where('id_antecedent', $i + 1)->count() == 0) ? array_push($this->etats_selectionnes_sm, 0) : array_push($this->etats_selectionnes_sm, 1);
        }
    }

    public function modif_etat($n)
    {
        $this->etats_selectionnes[$n] = ($this->etats_selectionnes[$n] == 1) ? 0 : 1;
        $this->etats_selectionnes_sm[$n] = ($this->etats_selectionnes_sm[$n] == 1) ? 0 : 1;
    }
    
    public function modif_etat_sm($n)
    {
        $this->etats_selectionnes[$n] = ($this->etats_selectionnes[$n] == 1) ? 0 : 1;
        $this->etats_selectionnes_sm[$n] = ($this->etats_selectionnes_sm[$n] == 1) ? 0 : 1;
    }

    public function modifierEtat()
    {
        $modif = 0;

        for ($i = 0; $i < Antecedent::count() - 1; $i++) {
            if ($this->etats_selectionnes[$i] == 1 && Etat::where('id_patient', $this->id_patient)->where('id_antecedent', $i + 1)->count() == 0) {
                Etat::create([
                    'id_patient' => $this->id_patient,
                    'id_antecedent' => $i + 1,
                ]);

                $modif = 1;
            }

            if ($this->etats_selectionnes[$i] == 0 && Etat::where('id_patient', $this->id_patient)->where('id_antecedent', $i + 1)->count() == 1) {
                Etat::find(Etat::where('id_patient', $this->id_patient)->where('id_antecedent', $i + 1)->get()[0]->id)->delete();
                $modif = 1;
            }
        }

        $commentaire_existe = Etat::where('id_patient', Patient::find($this->id_patient)->id)->where('id_antecedent', 28);

        if ($commentaire_existe->count() == 1) {
            if ($commentaire_existe->get('commentaire')[0]->commentaire != $this->commentaire) {
                Etat::find($commentaire_existe->get('id')[0])[0]->update([
                    'commentaire' => $this->commentaire,
                ]);

                $modif = 1;
            }
        } else {
            if ($this->commentaire != '') {
                Etat::create([
                    'id_patient' => $this->id_patient,
                    'id_antecedent' => 28,
                    'commentaire' => $this->commentaire,
                ]);

                $modif = 1;
            }
        }

        if ($modif == 1) {
            session()->flash('etat_maj', 'Etat modifié');
        } else {
            session()->flash('etat_non_maj', 'Aucune information modifiée');
        }   
    }

    public function supprimerCons($consId) {
        Consultation::find($consId)->supprimer();
    }

    public function render()
    {
        return view('livewire.dossier-patient', [
            'patient' => Patient::find($this->id_patient),
            'antecedents' => Antecedent::all(),
            'etats' => Etat::where('id_patient', Patient::find($this->id_patient)->id)->get(),
        ]);
    }
}

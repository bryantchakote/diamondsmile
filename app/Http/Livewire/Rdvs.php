<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rdv;
use App\Models\Patient;
use Livewire\WithPagination;

class Rdvs extends Component
{
    use WithPagination;
    
    public $mode = 'ajout';

    public $foo;
    public $n_nom_patient = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'n_nom_patient' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $n_date = '';
    public $n_motif = 'consultation';

    public $m_rdv = '';
    public $m_nom_patient = '';
    public $m_date = '';
    public $m_motif = '';

    public function mount()
    {
        $this->n_date = date('Y-m-d');
    }

    public function selectionner($patientId)
    {
        $this->n_nom_patient = Patient::find($patientId)->nom;
    }

    public function nouveauRdv()
    {
        $patient = Patient::where('nom', $this->n_nom_patient);

        if (!empty($patient->get('id')[0]->id)) {
            if (Rdv::where('date', $this->n_date)->where('motif', $this->n_motif)
                ->where('id_patient', $patient->get('id')[0]->id)->count() == 0) {
                Rdv::create([
                    'date' => $this->n_date,
                    'motif' => $this->n_motif,
                    'id_patient' => $patient->get('id')[0]->id,
                ]);

                session()->flash('rdv_ajoute', 'Rendez-vous ajouté');

                $this->n_nom_patient = '';
                $this->date = date('Y-m-d');
                $this->motif = 'consultation';

            } else {
                session()->flash('rdv_existant', 'Ce rendez-vous a déjà été programmé');
            }

        } else {
            session()->flash('nom_invalide', 'Nom de patient invalide');
        }
    }

    public function modeModif($rdvId)
    {
        $this->mode = 'modif';

        $this->m_rdv = Rdv::find($rdvId);

        $this->m_nom_patient = $this->m_rdv->patient->nom;
        $this->m_date = $this->m_rdv->date;
        $this->m_motif = $this->m_rdv->motif;
    }

    public function modeAjout()
    {
        $this->mode = 'ajout';

        $this->n_nom_patient = '';
        $this->n_date = '';
        $this->n_motif = '';
    }

    public function modifierRdv($rdvId)
    {
        if ($this->m_date != $this->m_rdv->date || $this->m_motif != $this->m_rdv->motif) {
            $this->m_rdv->update([
                'date' => $this->m_date,
                'motif' => $this->m_motif,
            ]);

            session()->flash('rdv_modifie', 'Rendez-vous modifié');

            $this->modeAjout();
            $this->mount();
        } else {
            session()->flash('rdv_non_modifie', 'Aucune information n\'a été modifiée');
        }
    }

    public function supprimerRdv($rdvId)
    {
        Rdv::find($rdvId)->delete();
        
        session()->flash('rdv_supprime', 'Rendez-vous supprimé');

        $this->mount();
    }

    public function render()
    {
        return view('livewire.rdvs', [
            'rdvs' => Rdv::latest('date')->paginate(25),
            'patients' => Patient::where('nom', 'like', '%'.$this->n_nom_patient.'%')->get(),
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Contrat;
use Livewire\WithPagination;

class Patients extends Component
{
    use WithPagination;

    public $mode = 'ajout';

    public $n_nom = '';
    public $n_sexe = 'M';
    public $n_date_nais = '';
    public $n_lieu_nais = '';
    public $n_adresse = '';
    public $n_tel = '';
    public $n_email = '';
    public $n_profession = '';
    public $n_referant = null;
    public $n_tel_referant = null;

    public $n_assurance = '';
    public $n_matricule = null;
    public $n_employeur = null;
    public $n_taux_couvert = '';
    public $n_valeur_D = '';

    public $m_patient = '';

    public $m_nom = '';
    public $m_sexe = '';
    public $m_date_nais = '';
    public $m_lieu_nais = '';
    public $m_adresse = '';
    public $m_tel = '';
    public $m_email = '';
    public $m_profession = '';
    public $m_referant = '';
    public $m_tel_referant = '';

    public $m_assurance = '';
    public $m_matricule = '';
    public $m_employeur = '';
    public $m_taux_couvert = '';
    public $m_valeur_D = '';

    public function mount()
    {
        $this->n_date_nais = Date('Y-m-d');
    }

    public function modeModif($patientId)
    {
        $this->mode = 'modif';

        $this->m_patient = Patient::find($patientId);

        $this->m_nom = $this->m_patient->nom;
        $this->m_sexe = ($this->m_patient->sexe == '') ? 'M' : $this->m_patient->sexe;
        $this->m_date_nais = $this->m_patient->date_nais;
        $this->m_lieu_nais = $this->m_patient->lieu_nais;
        $this->m_adresse = $this->m_patient->adresse;
        $this->m_tel = $this->m_patient->tel;
        $this->m_email = $this->m_patient->email;
        $this->m_profession = $this->m_patient->profession;
        $this->m_referant = $this->m_patient->referant;
        $this->m_tel_referant = $this->m_patient->tel_referant;

        $contrat = $this->m_patient->contrats->last();

        $this->m_assurance = $contrat->assurance;
        $this->m_matricule = $contrat->matricule;
        $this->m_employeur = $contrat->employeur;
        $this->m_taux_couvert = $contrat->taux_couvert;
        $this->m_valeur_D = $contrat->valeur_D;
    }

    public function modeAjout()
    {
        $this->mode = 'ajout';
    }


    public function nouveauPatient()
    {
        $patient = Patient::create([
            'nom' => $this->n_nom,
            'sexe' => $this->n_sexe,
            'date_nais' => ($this->n_date_nais != '') ? $this->n_date_nais : now(),
            'lieu_nais' => ($this->n_lieu_nais != '') ? $this->n_lieu_nais : null,
            'adresse' => ($this->n_adresse != '') ? $this->n_adresse : null,
            'tel' => ($this->n_tel != '') ? $this->n_tel : null,
            'email' => ($this->n_email != '') ? $this->n_email : null,
            'profession' => ($this->n_profession != '') ? $this->n_profession : null,
            'referant' => ($this->n_referant != '') ? $this->n_referant : null,
            'tel_referant' => ($this->n_tel_referant != '') ? $this->n_tel_referant : null,
        ]);

        Contrat::create([
            'id_patient' => $patient->id,
            'assurance' => ($this->n_assurance != '') ? $this->n_assurance : null,
            'matricule' => ($this->n_assurance != '') ? (($this->n_matricule != '') ? $this->n_matricule : null) : null,
            'employeur' => ($this->n_assurance != '') ? (($this->n_employeur != '') ? $this->n_employeur : null) : null,
            'taux_couvert' => ($this->n_taux_couvert == '' || !is_numeric($this->n_taux_couvert)) ? 0 : $this->n_taux_couvert,
            'valeur_D' => ($this->n_valeur_D == '' || !is_numeric($this->n_valeur_D)) ? 1000 : $this->n_valeur_D,
            'valeur_SC' => ($this->n_valeur_D == '' || !is_numeric($this->n_valeur_D)) ? 1200 : round($this->n_valeur_D * 1.2),
        ]);

        $this->n_nom = '';
        $this->n_sexe = '';
        $this->n_date_nais = '';
        $this->n_lieu_nais = '';
        $this->n_adresse = '';
        $this->n_tel = '';
        $this->n_email = '';
        $this->n_profession = '';
        $this->n_referant = null;
        $this->n_tel_referant = null;

        $this->n_assurance = '';
        $this->n_matricule = null;
        $this->n_employeur = null;
        $this->n_taux_couvert = '';

        session()->flash('patient_cree', 'Patient créé');
    }

    public function modifierPatient()
    {
        if ($this->m_patient != '') {
            $patient = Patient::find($this->m_patient->id);

            if (!is_null($patient)) {
                if ($patient->nom != $this->m_nom |
                    $patient->sexe != $this->m_sexe |
                    $patient->date_nais != $this->m_date_nais |
                    $patient->lieu_nais != $this->m_lieu_nais |
                    $patient->adresse != $this->m_adresse |
                    $patient->tel != $this->m_tel |
                    $patient->email != $this->m_email |
                    $patient->profession != $this->m_profession |
                    $patient->referant != $this->m_referant |
                    $patient->tel_referant != $this->m_tel_referant) {
                    $patient->update([
                        'nom' => $this->m_nom,
                        'sexe' => $this->m_sexe,
                        'date_nais' => ($this->m_date_nais != '') ? $this->m_date_nais : now(),
                        'lieu_nais' => ($this->m_lieu_nais != '') ? $this->m_lieu_nais : null,
                        'adresse' => ($this->m_adresse != '') ? $this->m_adresse : null,
                        'tel' => ($this->m_tel != '') ? $this->m_tel : null,
                        'email' => ($this->m_email != '') ? $this->m_email : null,
                        'profession' => ($this->m_profession != '') ? $this->m_profession : null,
                        'referant' => ($this->m_referant != '') ? $this->m_referant : null,
                        'tel_referant' => ($this->m_tel_referant != '') ? $this->m_tel_referant : null,
                    ]);

                    session()->flash('patient_modifie', 'Modifié');
                }

                if (Contrat::where([
                    'id_patient' => $this->m_patient->id,
                    'assurance' => $this->m_assurance,
                    'matricule' => $this->m_matricule,
                    'employeur' => $this->m_employeur,
                    'taux_couvert' => $this->m_taux_couvert,
                ])->count() == 0) {
                    Contrat::create([
                        'id_patient' => $this->m_patient->id,
                        'assurance' => ($this->m_assurance != '') ? $this->m_assurance : null,
                        'matricule' => ($this->m_assurance != '') ? (($this->m_matricule != '') ? $this->m_matricule : null) : null,
                        'employeur' => ($this->m_assurance != '') ? (($this->m_employeur != '') ? $this->m_employeur : null) : null,
                        'taux_couvert' => ($this->m_taux_couvert == '' || !is_numeric($this->m_taux_couvert)) ? 0 : $this->m_taux_couvert,
                        'valeur_D' => ($this->m_valeur_D == '' || !is_numeric($this->m_valeur_D)) ? 1000 : $this->m_valeur_D,
                        'valeur_SC' => ($this->m_valeur_D == '' || !is_numeric($this->m_valeur_D)) ? 1200 : round($this->m_valeur_D * 1.2),
                    ]);

                    session()->flash('patient_modifie', 'Modifié');
                }
            }
        }
    }

    public function supprimerPatient() {
        if ($this->m_patient != '') {
            $this->m_patient->supprimer();
            
            $this->m_patient = '';

            $this->m_nom = '';
            $this->m_sexe = '';
            $this->m_date_nais = '';
            $this->m_lieu_nais = '';
            $this->m_adresse = '';
            $this->m_tel = '';
            $this->m_email = '';
            $this->m_profession = '';
            $this->m_referant = '';
            $this->m_tel_referant = '';

            $this->m_assurance = '';
            $this->m_matricule = '';
            $this->m_employeur = '';
            $this->m_taux_couvert = '';
            $this->m_valeur_D = '';
        }
    }

    public function render()
    {
        return view('livewire.patients', [
            'patients' => Patient::orderBy('nom')->paginate(25),
        ]);
    }
}

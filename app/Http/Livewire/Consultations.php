<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Facture;
use App\Models\Visite;
use App\Models\Examen;
use App\Models\Prescription;
use App\Models\Plan;
use App\Models\Operation;
use App\Models\Reglement;

class Consultations extends Component
{
    public $id_patient = '';
    public $id_cons = '';
    public $date = '';
    public $frais = 10000;
    public $medocs_en_cours = '';
    public $observations = '';
    public $confirmer_nouvelle_date = 0;

    public function mount($patientId)
    {
        $this->id_patient = $patientId;

        $visite = Visite::where([
            'id_patient' => $this->id_patient,
            'date' => date('Y-m-d'),
            'motif' => 'consultation',
        ])->get();

        if (count($visite) == 0) {
            Visite::create([
                'date' => now(),
                'derniere_visite' => (Patient::find($this->id_patient)->visites->count() > 0) ? Patient::find($this->id_patient)->visites->sortByDesc('date')->values()->all()[0]->date : null,
                'motif' => 'consultation',
                'id_patient' => Patient::find($this->id_patient)->id,
            ]);

            Consultation::create([
                'medocs_en_cours' => null,
                'observations' => null,
                'frais' => 10000,
                'id_visite' => Visite::all()->last()->id,
            ]);
        } else {
            Visite::find($visite[0]->id)->update([
                'motif' => '',
            ]);
            Visite::find($visite[0]->id)->update([
                'motif' => 'consultation',
            ]);

            $frais = Consultation::find($visite[0]->consultation->id)->frais;
            Consultation::find($visite[0]->consultation->id)->update([
                'frais' => 0,
            ]);
            Consultation::find($visite[0]->consultation->id)->update([
                'frais' => $frais,
            ]);
        }

        $cons = Consultation::orderByDesc('updated_at')->get()[0];

        $this->id_cons = $cons->id;
        $this->date = $cons->visite->date;
        $this->frais = $cons->frais;
        $this->medocs_en_cours = $cons->medocs_en_cours;
        $this->observations = $cons->observations;
    }

    public function nouvelleDate() {
        // Pour l'actualisation des exams, prescriptions et plans lorsque id_cons est modifie
        $this->confirmer_nouvelle_date = ($this->confirmer_nouvelle_date == 0) ? 1 : 0;

        // Visite existante a cette nouvelle date?
        $visite = Visite::where([
            'id_patient' => $this->id_patient,
            'date' => $this->date,
            'motif' => 'consultation',
        ])->get();

        // Infos visite en cours avant le changement de date
        $cons = Consultation::find($this->id_cons);

        $medocs_en_cours = $cons->medocs_en_cours;
        $observations = $cons->observations;

        $exams = Examen::where('id_cons', $cons->id);
        $prescs = Prescription::where('id_visite', $cons->visite->id);
        $plans = Plan::where('id_cons', $cons->id);

        // Differents cas possibles
        if (count($visite) == 0) {
            if ((is_null($medocs_en_cours) || $medocs_en_cours == '') &&
                (is_null($observations) || $observations == '') &&
                $exams->count() == 0 && $prescs->count() == 0 && $plans->count() == 0) {
                Visite::find($cons->visite->id)->update([
                    'date' => $this->date,
                    'derniere_visite' => (Patient::find($this->id_patient)->visites->where('date', '<=', $this->date)->count() > 0) ? Patient::find($this->id_patient)->visites->where('date', '<=', $this->date)->sortByDesc('date')->values()->all()[0]->date : null,
                ]);
            } else {
                Visite::create([
                    'date' => $this->date,
                    'derniere_visite' => (Patient::find($this->id_patient)->visites->where('date', '<=', $this->date)->count() > 0) ? Patient::find($this->id_patient)->visites->where('date', '<=', $this->date)->sortByDesc('date')->values()->all()[0]->date : null,
                    'motif' => 'consultation',
                    'id_patient' => Patient::find($this->id_patient)->id,
                ]);

                Consultation::create([
                    'medocs_en_cours' => null,
                    'observations' => null,
                    'frais' => 10000,
                    'id_visite' => Visite::all()->last()->id,
                ]);
            }
        } else {
            if ((is_null($medocs_en_cours) || $medocs_en_cours == '') &&
                (is_null($observations) || $observations == '') &&
                $exams->count() == 0 && $prescs->count() == 0 && $plans->count() == 0) {
                $cons->visite->delete();
                $cons->delete();
            }

            Visite::find($visite[0]->id)->update([
                'date' => '1970-01-01',
            ]);

            Visite::find($visite[0]->id)->update([
                'date' => $this->date,
            ]);
        }

        $visite_maj = Visite::orderByDesc('updated_at')->get()[0];
        $cons = $visite_maj->consultation;

        $this->id_cons = $cons->id;
        $this->frais = $cons->frais;
        $this->medocs_en_cours = $cons->medocs_en_cours;
        $this->observations = $cons->observations;
    }

    public function ajouter_cons()
    {
        $cons = Consultation::find($this->id_cons);

        $exams = Examen::where('id_cons', $this->id_cons);
        $prescs = Prescription::where('id_visite', $cons->visite->id);
        $plans = Plan::where('id_cons', $this->id_cons);

        if (!((is_null($this->medocs_en_cours) || $this->medocs_en_cours == '') &&
            (is_null($this->observations) || $this->observations == '') &&
            $exams->count() == 0 && $prescs->count() == 0 && $plans->count() == 0)) {
            
            $cons->update([
                'medocs_en_cours' => $this->medocs_en_cours,
                'observations' => $this->observations,
                'frais' => $this->frais,
            ]);

            if ($plans->count() > 0) {
                $id_facture = (Facture::all()->count() > 0) ? (Facture::all()->last()->id + 1) : 1;
                return redirect('facture/' . $id_facture);
            } else {
                if (Prescription::where('id_visite', $cons->visite->id)->count() > 0) {
                    redirect('../../ordonnance/' . $cons->visite->id);
                } else {
                    redirect('patient/' . $this->id_patient);
                }
            }
        } else {
            $cons->visite->delete();
            $cons->delete();

            return redirect('patient/' . $this->id_patient);
        }
    }

    public function annuler() {
        Consultation::find($this->id_cons)->supprimer(0);
    }

    public function render()
    {
        return view('livewire.consultations', [
            'consultation' => $this->id_cons != '' ? Consultation::find($this->id_cons) : null,
        ]);
    }
}

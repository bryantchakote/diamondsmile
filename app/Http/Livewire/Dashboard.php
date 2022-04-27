<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Contrat;
use App\Models\Visite;
use App\Models\Rdv;
use App\Models\Antecedent;
use App\Models\Plan;
use App\Models\Reglement;
use Carbon\Carbon;
use DB;

class Dashboard extends Component
{
    public $nbre_patients;
    public $hommes;
    public $femmes;
    public $assures;
    public $non_assures;
    public $freq_hommes;
    public $freq_femmes;
    public $freq_assures;
    public $freq_non_assures;
    public $ages = [];
    public $max_visites;
    public $rdvs;
    public $antecedents;
    public $nb_plans;
    public $nb_plans_conf;
    public $freq_plans_conf;
    public $nb_plans_term;
    public $freq_plans_term;
    public $debut;
    public $fin;
    public $CA;
    public $CA_total;
    public $dette;
    public $visites_periode;
    public $reglements_periode;
    public $factures_periode;
    public $anniversaires;

    public function mount() {
        // Patients
        $this->nbre_patients = Patient::count();

        $this->hommes = Patient::where('sexe', 'M')->count();
        $this->femmes = Patient::where('sexe', 'F')->count();
        $this->assures = Contrat::latest()->distinct('id_patient')->whereNotNull('assurance')->count();
        $this->non_assures = Contrat::latest()->distinct('id_patient')->whereNull('assurance')->count();

        $this->freq_hommes = ($this->nbre_patients != 0) ? round(($this->hommes / $this->nbre_patients) * 100, 2) : 0;
        $this->freq_femmes = ($this->nbre_patients != 0) ? round(($this->femmes / $this->nbre_patients) * 100, 2) : 0;
        $this->freq_assures = ($this->nbre_patients != 0) ? round(($this->assures / $this->nbre_patients) * 100, 2) : 0;
        $this->freq_non_assures = ($this->nbre_patients != 0) ? round(($this->non_assures / $this->nbre_patients) * 100, 2) : 0;

        $this->ages = [
            '5' => Patient::whereDate('date_nais', '>', now()->subYears(5))->count(),
            '5-15' => Patient::whereBetween('date_nais', [now()->subYears(15), now()->subYears(5)])->count(),
            '15-25' => Patient::whereBetween('date_nais', [now()->subYears(25), now()->subYears(15)])->count(),
            '25-35' => Patient::whereBetween('date_nais', [now()->subYears(35), now()->subYears(25)])->count(),
            '35-45' => Patient::whereBetween('date_nais', [now()->subYears(45), now()->subYears(35)])->count(),
            '45-55' => Patient::whereBetween('date_nais', [now()->subYears(55), now()->subYears(45)])->count(),
            '55' => Patient::whereDate('date_nais',  '<', now()->subYears(55))->count(),
        ];

        $visites = Visite::all()->groupBy('id_patient');
        $patients = [];
        $visites_patient = [];
        
        foreach ($visites as $patient => $visite) {
            array_push($patients, $patient);
            array_push($visites_patient, $visite->count());
        }

        // Rdvs
        $this->rdvs = Rdv::where('date', '>=', now()->subHours(now()->hour + 1))->orderBy('date')->take(5)->get();

        // Antecedents
        $this->antecedents = Antecedent::all();

        // Traitements
        $this->nb_plans = Plan::count();
        $this->nb_plans_conf = Plan::where('confirme', 1)->count();
        $this->freq_plans_conf = ($this->nb_plans != 0) ? round(($this->nb_plans_conf / $this->nb_plans) * 100, 2) : 0;
        $this->nb_plans_term = Plan::where('termine', 1)->count();
        $this->freq_plans_term = ($this->nb_plans_conf != 0) ? round(($this->nb_plans_term / $this->nb_plans_conf) * 100, 2) : 0;
        
        // Divers
        $this->debut = Visite::oldest('date')->first()->date ?? date('Y-m-d');
        $this->fin = date('Y-m-d');

        $this->visites_periode = Visite::whereBetween('date', [$this->debut, $this->fin])->get();
        
        $this->reglements_periode = Reglement::whereBetween('date', [$this->debut, $this->fin])->get();

        $this->CA = 0;
        $this->CA_total = 0;
        $this->dette = 0;

        if ($this->reglements_periode->count() > 0) {
            foreach ($this->reglements_periode as $reglement) {
                $this->CA += $reglement->montant;
            }
        }

        if ($this->visites_periode->count() > 0) {
            foreach ($this->visites_periode as $visite) {
                $factures_periode = $visite->factures;

                if ($factures_periode->count() > 0) {
                    foreach ($factures_periode as $facture) {
                        $this->CA_total += $facture->total * (1 - $facture->remise / 100);
                    }
                }
            }
            
            $this->dette = $this->CA_total - $this->CA;
        }

        // Anniversaires
        $this->anniversaires = Patient::where(DB::raw('substr(date_nais, 6, 10)'), '=', substr(now(), 5, 5))->get();
    }

    public function modif() {
        $this->visites_periode = Visite::whereBetween('date', [$this->debut, $this->fin])->get();
        
        $this->CA = 0;
        $this->CA_total = 0;
        $this->dette = 0;
        
        $this->reglements_periode = Reglement::whereBetween('date', [$this->debut, $this->fin])->get();
        
        if ($this->reglements_periode->count() > 0) {
            foreach ($this->reglements_periode as $reglement) {
                $this->CA += $reglement->montant;
            }
        }

        if ($this->visites_periode->count() > 0) {
            foreach ($this->visites_periode as $visite) {
                $factures_periode = $visite->factures;

                if ($factures_periode->count() > 0) {
                    foreach ($factures_periode as $facture) {
                        $this->CA_total += $facture->total * (1 - $facture->remise / 100);
                    }
                }
            }

            $this->dette = $this->CA_total - $this->CA;
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

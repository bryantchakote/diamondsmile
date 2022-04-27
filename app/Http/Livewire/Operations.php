<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Operation;
use App\Models\Patient;
use App\Models\Visite;
use App\Models\Consultation;
use App\Models\Plan;
use App\Models\Traitement;
use App\Models\Facture;
use App\Models\Prescription;

class Operations extends Component
{
    public $id_patient = '';
    public $date = '';
    public $visite_actuelle = '';
    public $visites = '';
    public $consultations = '';
    public $operations = [];
    public $nouveaux_plans = [];
    public $prix = [];
    public $plans_conf = [];
    public $autres_plans = [];
    public $commentaire = [];
    public $plans_termines = [];
    public $operations_ajoutees = [];
    public $plans_ajoutes = [];
    public $derniers_plans_termines = [];
    public $plans_facture = [];
    public $prix_facture = [];
    public $presc = '';
    public $bouton_terminer = '';

    public function mount($patientId, $date)
    {
        $this->id_patient = $patientId;

        $this->visites = Visite::orderByDesc('date')->where('id_patient', $this->id_patient)->get('id');
        $this->consultations = Consultation::whereIn('id_visite', $this->visites)->get('id');

        $plans = Plan::whereIn('id_cons', $this->consultations);
        $this->plans_conf = $plans->where('confirme', 1)->where('termine', 0)->get();
        $this->autres_plans = $plans->where('confirme', 0)->get();

        $this->date = $date;

        $visite = Visite::where([
            'id_patient' => $this->id_patient,
            'date' => $this->date,
            'motif' => 'traitement',
        ])->get();

        if (count($visite) > 0) {
            $this->visite_actuelle = Visite::find($visite[0]->id);
        }

        $this->presc = (count($visite) == 0) ? 0 : 1;
        $this->bouton_terminer = (count($visite) == 0) ? 0 : 1;
    }

    public function supprimerPlan($planId)
    {
        Plan::find($planId)->delete();
        $this->mount($this->id_patient, $this->date);
    }

    public function nouvelleDate() {
        $this->operations = [];
        $this->nouveaux_plans = [];
        $this->prix = [];
        $this->commentaire = [];
        $this->plans_termines = [];
        $this->operations_ajoutees = [];
        $this->plans_ajoutes = [];
        $this->derniers_plans_termines = [];

        $visite = Visite::where([
            'id_patient' => $this->id_patient,
            'date' => $this->date,
            'motif' => 'traitement',
        ])->get();

        if (count($visite) > 0) {
            $this->visite_actuelle = Visite::find($visite[0]->id);
        }

        $this->presc = (count($visite) == 0) ? 0 : 1;
        $this->bouton_terminer = (count($visite) == 0) ? 0 : 1;
    }

    public function ajouterOperation($planId) {
        if (!in_array($planId, $this->operations)) {
            array_push($this->operations, $planId);
            array_push($this->commentaire, '');
            array_push($this->plans_termines, 0);
        }
    }

    public function validerOperation($planId) {
        $visite = Visite::where([
            'id_patient' => $this->id_patient,
            'date' => $this->date,
            'motif' => 'traitement',
        ])->get();

        if (count($visite) == 0) {
            Visite::create([
                'date' => $this->date,
                'derniere_visite' => Patient::find($this->id_patient)->visites->where('date', '<=', $this->date)->sortByDesc('date')->values()->all()[0]->date,
                'motif' => 'traitement',
                'id_patient' => $this->id_patient,
            ]);
        } else {
            Visite::find($visite[0]->id)->update([
                'motif' => '',
            ]);

            Visite::find($visite[0]->id)->update([
                'motif' => 'traitement',
            ]);
        }

        $this->visite_actuelle = Visite::latest('updated_at')->get()[0];

        # Enregistrement eventuel de l'operation
        $index = array_search($planId, $this->operations);
            
        $operations = Operation::where([
            'commentaire' => ($this->commentaire[$index] != '') ? $this->commentaire[$index] : null,
            'id_plan' => $planId,
            'id_visite' => $this->visite_actuelle->id,
        ])->get();

        if (count($operations) == 0) {
            Operation::create([
                'commentaire' => ($this->commentaire[$index] != '') ? $this->commentaire[$index] : null,
                'id_plan' => $planId,
                'id_visite' => $this->visite_actuelle->id,
            ]);

            array_push($this->operations_ajoutees, Operation::all()->last()->id);

            if ($this->plans_termines[$index] == 1) {
                $plan = Plan::find($planId);
                $plan->update([
                    'termine' => 1,
                ]);

                array_push($this->derniers_plans_termines, Plan::latest('updated_at')->get()[0]->id);

                for ($i = $index; $i < count($this->operations) - 1; $i++) {
                    $this->operations[$i] = $this->operations[$i+1];
                    $this->commentaire[$i] = $this->commentaire[$i+1];
                    $this->plans_termines[$i] = $this->plans_termines[$i+1];
                }

                $last = count($this->operations) - 1;

                unset($this->operations[$last]);
                unset($this->commentaire[$last]);
                unset($this->plans_termines[$last]);
            }

            $this->mount($this->id_patient, $this->date);

            session()->flash('operation_validee', 'Validé');

            # Permettre prescription et bouton terminer
            $this->presc = 1;
            $this->bouton_terminer = 1;
        } else {
            session()->flash('operation_existante', '!!!');
        }
    }

    public function plan_termine($i) {
        $this->plans_termines[$i] = ($this->plans_termines[$i] == 0) ? 1 : 0;
    }

    public function confirmerPlan($planId) {
        if (!in_array($planId, $this->nouveaux_plans)) {
            array_push($this->nouveaux_plans, $planId);
            array_push($this->prix, Plan::find($planId)->prix);
        }
    }

    public function deconf_plan($planId) {
        $index = array_search($planId, $this->nouveaux_plans);

        for ($i = $index; $i < count($this->nouveaux_plans) - 1; $i++) {
            $this->nouveaux_plans[$i] = $this->nouveaux_plans[$i+1];
            $this->prix[$i] = $this->prix[$i+1];
        }

        $last = count($this->nouveaux_plans) - 1;

        unset($this->nouveaux_plans[$last]);
        unset($this->prix[$last]);
    }

    public function ajouterPlan() {
        foreach ($this->nouveaux_plans as $nouveau_plan) {
            $index = array_search($nouveau_plan, $this->nouveaux_plans);

            Plan::find($nouveau_plan)->update([
                'prix' => $this->prix[$index],
                'confirme' => 1,
            ]);

            array_push($this->plans_ajoutes, Plan::latest('updated_at')->get()[0]->id);

            array_push($this->plans_facture, $nouveau_plan);
            array_push($this->prix_facture, $this->prix[$index]);

            for ($i = $index; $i < count($this->nouveaux_plans) - 1; $i++) {
                $this->nouveaux_plans[$i] = $this->nouveaux_plans[$i+1];
                $this->prix[$i] = $this->prix[$i+1];
            }

            $last = count($this->nouveaux_plans) - 1;

            unset($this->nouveaux_plans[$last]);
            unset($this->prix[$last]);
        }

        for ($i = 0; $i < count($this->nouveaux_plans); $i++) {
            unset($this->nouveaux_plans_conf);
            unset($this->prix);
        }

        $this->mount($this->id_patient, $this->date);
    }

    public function terminer() {
        $this->visite_actuelle = Visite::latest('updated_at')->get()[0];

        if (count($this->plans_facture) > 0) {
            $total = 0;

            foreach ($this->prix_facture as $prix) {
                $total += $prix;
            }

            Facture::create([
                'total' => $total,
                'remise' => 0,
                'reglee_assureur' => (Patient::find($this->id_patient)->contrats->last()->taux_couvert == 0) ? 1 : 0,
                'reglee_assure' => 0,
                'id_visite' => $this->visite_actuelle->id,
            ]);

            $id_facture = (Facture::all()->count() > 0) ? (Facture::all()->last()->id + 1) : 1;

            return redirect('facture_2/' . $id_facture);
        }

        if (Prescription::where('id_visite', $this->visite_actuelle->id)->count() > 0) {
            return redirect('../../ordonnance/' . $this->visite_actuelle->id);
        }

        return redirect('patient/' . $this->id_patient);
    }

    public function annuler()
    {
        foreach ($this->plans_ajoutes as $plan_ajoute) {
            Plan::find($plan_ajoute)->update([
                'confirme' => 0,
            ]);
        }

        if ($this->bouton_terminer) {
            $visite = Visite::all()->last();

            $operations = $visite->operations;
            if (count($operations) > 0) {
                foreach ($operations as $operation) {
                    Operation::find($operation->id)->plan->update(['termine' => 0]);
                    Operation::find($operation->id)->delete();
                }
            }

            $prescs = $visite->prescriptions;
            if (count($prescs) > 0) {
                foreach ($prescs as $presc) {
                    Prescription::find($presc->id)->delete();
                }
            }

            $facture = $visite->factures;
            if (count($factures) > 0) {
                foreach ($factures as $facture) {
                    $facture = Facture::find($facture->id);
                    $reglements = $facture->reglements;

                    if (count($reglements) > 0) {
                        foreach ($reglements as $reglement) {
                            Reglement::find($reglement->id)->delete();
                        }
                    }

                    $facture->delete();
                }
            }

            Visite::find(Visite::all()->last()->id)->delete();
        }

        return redirect('patient/' . $this->id_patient);
    }

    public function render()
    {
        return view('livewire.operations');
    }
}

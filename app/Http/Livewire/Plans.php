<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Plan;
use App\Models\Consultation;
use App\Models\Traitement;

class Plans extends Component
{
    public $id_cons = '';
    public $id_patient = '';
    public $traits_selectionnes = [];
    public $mode_editer_traitement = 0;
    public $dents = [];
    public $desc = [];
    public $duree = [];
    public $prix = [];
    public $plans_conf = [];

    public function mount($consId)
    {
        // $this->id_cons =  Consultation::orderByDesc('updated_at')->get()[0]->id;
        $this->id_cons = $consId;
        $this->id_patient = Consultation::find($this->id_cons)->visite->patient->id;
    }

    public function ajout_traitement($traitementId)
    {
        if (in_array($traitementId, $this->traits_selectionnes)) {
            $index = array_search($traitementId, $this->traits_selectionnes);

            for ($i = $index; $i < count($this->traits_selectionnes) - 1; $i++) {
                $this->dents[$i] = $this->dents[$i+1];
                $this->desc[$i] = $this->desc[$i+1];
                $this->duree[$i] = $this->duree[$i+1];
                $this->prix[$i] = $this->prix[$i+1];
                $this->traits_selectionnes[$i] = $this->traits_selectionnes[$i+1];
            }

            if (in_array($traitementId, $this->plans_conf)) {
                for ($i = array_search($traitementId, $this->plans_conf); $i < count($this->plans_conf) - 1; $i++) {
                    $this->plans_conf[$i] = $this->plans_conf[$i+1];
                }

                unset($this->plans_conf[count($this->plans_conf) - 1]);
            }

            $last = count($this->traits_selectionnes) -1;

            unset($this->dents[$last]);
            unset($this->desc[$last]);
            unset($this->duree[$last]);
            unset($this->prix[$last]);
            unset($this->traits_selectionnes[$last]);
        } else {
            array_push($this->traits_selectionnes, $traitementId);

            array_push($this->dents, '');
            array_push($this->desc, '');
            array_push($this->duree, '');
            array_push($this->prix, Traitement::find($traitementId + 1)->prix($this->id_patient));

            array_push($this->plans_conf, $traitementId);
        }

        $this->mode_editer_traitement = (count($this->traits_selectionnes) == 0) ? 0 : 1;
    }

    public function conf_plan($traitementId)
    {
        $traitementId -= 1;

        if (in_array($traitementId, $this->plans_conf)) {
            $index = array_search($traitementId, $this->plans_conf);

            for ($i = $index; $i < count($this->plans_conf) - 1; $i++) {
                $this->plans_conf[$i] = $this->plans_conf[$i+1];
            }

            $last = count($this->plans_conf) - 1;

            unset($this->plans_conf[$last]);
        } else {
            array_push($this->plans_conf, $traitementId);
        }
    }

    public function ajouterPlan()
    {
        $modif = 0;

        foreach ($this->traits_selectionnes as $trait_selectionne) {
            $index = array_search($trait_selectionne, $this->traits_selectionnes);

            if (Plan::where('id_cons', $this->id_cons)->where('id_trait', $trait_selectionne + 1)->count() == 0) {
                Plan::create([
                    'dents' => $this->dents[$index],
                    'desc' => $this->desc[$index],
                    'duree' => $this->duree[$index],
                    'prix' => (is_null($this->prix[$index]) || $this->prix[$index] == '') ? 0 : $this->prix[$index],
                    'confirme' => in_array($trait_selectionne, $this->plans_conf) ? 1 : 0,
                    'termine' => 0,
                    'id_cons' => $this->id_cons,
                    'id_trait' => $trait_selectionne + 1,
                ]);

                $modif = 1;
            } else {
                $plan = Plan::find(Plan::where('id_cons', $this->id_cons)->where('id_trait', $trait_selectionne + 1)->get()[0]->id);

                $confirme = in_array($trait_selectionne, $this->plans_conf);

                if (($plan->dents != $this->dents[$index]) || ($plan->desc != $this->desc[$index]) ||
                    ($plan->duree != $this->duree[$index]) || ($plan->prix != $this->prix[$index]) ||
                    ($plan->confirme != $confirme)) {
                    $plan->update([
                        'dents' => $this->dents[$index],
                        'desc' => $this->desc[$index],
                        'duree' => $this->duree[$index],
                        'prix' => (is_null($this->prix[$index]) || $this->prix[$index] == '') ? 0 : $this->prix[$index],
                        'confirme' => in_array($trait_selectionne, $this->plans_conf) ? 1 : 0,
                    ]);

                    $modif = 1;
                }
            }
        }

        if ($modif) {
            session()->flash('plan_modifie', 'Validé');
        }
    }

    public function render()
    {
        return view('livewire.plans', [
            'traitements' => Traitement::all()->groupBy('type'),
            'types' => Traitement::select('type')->distinct()->get(),
        ]);
    }
}

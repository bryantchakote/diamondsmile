<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Visite;
use App\Models\Patient;
use App\Models\Examen;
use App\Models\Consultation;

class Visites extends Component
{
    public $id_patient = '';
    public $id_cons = '';
    public $denture = [];
    public $paradontal = [];
    public $showDiv = [];

    public function mount($patientId)
    {
        $this->id_patient = $patientId;

        $visites = Visite::where('id_patient', $this->id_patient)->orderByDesc('date')->get();

        foreach ($visites as $visite) {
            if (!is_null($visite->consultation)) {
                $id_cons = $visite->consultation->id;
                $one = [];
                for ($bloc = 0; $bloc < 8; $bloc++) {
                    $two = [];
                    for ($dent = 0; $dent < 8; $dent++) {
                        $three = [];
                        for ($zone = 0; $zone < 6; $zone++) {                            
                            $exam_existant = Examen::where([
                                'nom' => 'denture',
                                'bloc' => $bloc + 1,
                                'dent' => $dent + 1,
                                'zone' => $zone + 1,
                                'id_cons' => $id_cons,
                            ]);

                            ($exam_existant->count() == 0) ? array_push($three, 0) : array_push($three, 1);
                        }
                        array_push($two, $three);
                    }
                    array_push($one, $two);
                }
                array_push($this->denture, $one);

                $one = [];
                for ($bloc = 0; $bloc < 4; $bloc++) {
                    $two = [];
                    for ($dent = 0; $dent < 8; $dent++) {
                        $three = [];                        
                        for ($zone = 0; $zone < 4; $zone++) {
                            $exam_existant = Examen::where([
                                'nom' => 'paradontal',
                                'bloc' => $bloc + 1,
                                'dent' => $dent + 1,
                                'zone' => $zone + 1,
                                'id_cons' => $id_cons,
                            ]);

                            ($exam_existant->count() == 0) ? array_push($three, '') : array_push($three, $exam_existant->get()[0]->commentaire);
                        }
                        array_push($two, $three);
                    }
                    array_push($one, $two);
                }
                array_push($this->paradontal, $one);
            }

            $this->showDiv[$visite->id] = 0;
        }
    }

    public function openDiv($idVisite)
    {
        $this->showDiv[$idVisite] = ($this->showDiv[$idVisite] == 0) ? 1 : 0;
    }

    public function supprimerCons($idCons) {
        Consultation::find($idCons)->supprimer(0);
    }

    public function supprimerTrait($idVisite) {
        Visite::find($idVisite)->supprimer(0);
    }

    public function render()
    {
        return view('livewire.visites', [
            'visites' => Visite::where('id_patient', $this->id_patient)->latest('date')->latest('id')->get(),
            'nb' => count($this->showDiv),
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Examen;
use App\Models\Consultation;

class Examens extends Component
{
    public $id_cons = '';
    public $denture = [];
    public $paradontal = [];

    public function mount($consId)
    {
        $this->id_cons = $consId;

        for ($bloc = 0; $bloc < 4; $bloc++) {
            $one = [];
            for ($dent = 0; $dent < 8; $dent++) {
                $two = [];
                for ($zone = 0; $zone < 6; $zone++) {
                    $exam_existant = Examen::where([
                        'nom' => 'denture',
                        'bloc' => $bloc + 1,
                        'dent' => $dent + 1,
                        'zone' => $zone + 1,
                        'id_cons' => $this->id_cons,
                    ]);

                    ($exam_existant->count() == 0) ? array_push($two, 0) : array_push($two, 1);
                }
                array_push($one, $two);
            }
            array_push($this->denture, $one);
        }

        for ($bloc = 4; $bloc < 8; $bloc++) {
            $one = [];
            for ($dent = 0; $dent < 8; $dent++) {
                $two = [];
                for ($zone = 0; $zone < 6; $zone++) {
                    $exam_existant = Examen::where([
                        'nom' => 'denture',
                        'bloc' => $bloc + 1,
                        'dent' => $dent + 1,
                        'zone' => $zone + 1,
                        'id_cons' => $this->id_cons,
                    ]);

                    ($exam_existant->count() == 0) ? array_push($two, 0) : array_push($two, 1);
                }
                array_push($one, $two);
            }
            array_push($this->denture, $one);
        }

        for ($bloc = 0; $bloc < 4; $bloc++) {
            $one = [];
            for ($dent = 0; $dent < 8; $dent++) {
                $two = [];
                for ($zone = 0; $zone < 4; $zone++) {
                    $exam_existant = Examen::where([
                        'nom' => 'paradontal',
                        'bloc' => $bloc + 1,
                        'dent' => $dent + 1,
                        'zone' => $zone + 1,
                        'id_cons' => $this->id_cons,
                    ]);

                    ($exam_existant->count() == 0) ? array_push($two, '') : array_push($two, $exam_existant->get()[0]->commentaire);
                }
                array_push($one, $two);
            }
            array_push($this->paradontal, $one);
        }
    }

    public function denture($bloc, $dent, $zone)
    {
        $this->denture[$bloc][$dent][$zone] = $this->denture[$bloc][$dent][$zone] ? 0 : 1;
    }

    public function examenDenture()
    {
        $ex_denture = 0;

        for ($bloc = 0; $bloc < 8; $bloc++) {
            for ($dent = 0; $dent < 8; $dent++) {
                for ($zone = 0; $zone < 6; $zone++) {
                    $exam_existant = Examen::where([
                        'nom' => 'denture',
                        'bloc' => $bloc + 1,
                        'dent' => $dent + 1,
                        'zone' => $zone + 1,
                        'id_cons' => $this->id_cons,
                    ]);

                    if ($exam_existant->count() > 0) {
                        Examen::find($exam_existant->get()[0]->id)->update([
                            'nom' => 'denture',
                            'bloc' => $bloc + 1,
                            'dent' => $dent + 1,
                            'zone' => $zone + 1,
                            'commentaire' => null,
                            'id_cons' => $this->id_cons,
                        ]);
                    }

                    if (($this->denture[$bloc][$dent][$zone] == 1) && ($exam_existant->count() == 0)) {
                        Examen::create([
                            'nom' => 'denture',
                            'bloc' => $bloc + 1,
                            'dent' => $dent + 1,
                            'zone' => $zone + 1,
                            'commentaire' => null,
                            'id_cons' => $this->id_cons,
                        ]);

                        $ex_denture = 1;
                    }

                    if (($this->denture[$bloc][$dent][$zone] == 0) && ($exam_existant->count() == 1)) {
                        Examen::find($exam_existant->get()[0]->id)->delete();

                        $ex_denture = 1;
                    }
                }
            }
        }

        $ex_denture ? session()->flash('ex_denture', 'Enregistré') : session()->flash('non_ex_denture', 'Aucune modification');
    }

    public function examenParadontal()
    {
        $ex_paradontal = 0;

        for ($bloc = 0; $bloc < 4; $bloc++) {
            for ($dent = 0; $dent < 8; $dent++) {
                for ($zone = 0; $zone < 4; $zone++) {
                    $exam_existant = Examen::where([
                        'nom' => 'paradontal',
                        'bloc' => $bloc + 1,
                        'dent' => $dent + 1,
                        'zone' => $zone + 1,
                        'id_cons' => $this->id_cons,
                    ]);

                    if ($exam_existant->count() > 0) {
                        Examen::find($exam_existant->get()[0]->id)->update([
                            'nom' => 'paradontal',
                            'bloc' => $bloc + 1,
                            'dent' => $dent + 1,
                            'zone' => $zone + 1,
                            'commentaire' => $this->paradontal[$bloc][$dent][$zone],
                            'id_cons' => $this->id_cons,
                        ]);

                        $ex_paradontal = 1;
                    }

                    if (($this->paradontal[$bloc][$dent][$zone] != '') && ($exam_existant->count() == 0)) {
                        Examen::create([
                            'nom' => 'paradontal',
                            'bloc' => $bloc + 1,
                            'dent' => $dent + 1,
                            'zone' => $zone + 1,
                            'commentaire' => $this->paradontal[$bloc][$dent][$zone],
                            'id_cons' => $this->id_cons,
                        ]);

                        $ex_paradontal = 1;
                    }

                    if (($this->paradontal[$bloc][$dent][$zone] == '') && ($exam_existant->count() == 1)) {
                        Examen::find($exam_existant->get()[0]->id)->delete();

                        $ex_paradontal = 1;
                    }
                }
            }
        }

        $ex_paradontal ? session()->flash('ex_paradontal', 'Enregistré') : session()->flash('non_ex_paradontal', 'Aucune modification');
    }

    public function render()
    {
        return view('livewire.examens');
    }
}

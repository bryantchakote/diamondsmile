<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Consultation;
use App\Models\Traitement;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Dents ?
        $hasDents = $this->faker->boolean(80);
        
        if ($hasDents) {
            $dents = '';

            $mode_liste = $this->faker->boolean(70);

            if ($mode_liste) {
                $nombreMaxDents = rand(1, 7);
                $listeDents = [];

                for ($i = 0; $i < $nombreMaxDents; $i++) {
                    array_push($listeDents, rand(1, 4) . rand(1, 8));
                }

                $listeDents = array_unique($listeDents);

                foreach ($listeDents as $dent) {
                    $dents .= $dent . ', ';
                }
                
                $dents .= rand(1, 4) . rand(1, 8);
            } else {
                $mode_quadran = $this->faker->boolean(70);

                if ($mode_quadran) {
                    $dents = 'Quadran ' . rand(1, 4);
                } else {
                    $dents = 'Toutes';
                }
            }            
        } else {
            $dents = null;
        }

        // Description ?
        $hasDesc = $this->faker->boolean(80);

        // Duree ?
        $hasDuree = $this->faker->boolean(60);
        
        while (true) {
            $id_cons = rand(1, Consultation::count());
            $id_trait = rand(1, Traitement::count());

            $prix = Traitement::find($id_trait)->prix(Consultation::find($id_cons)->visite->patient->id);

            if (!is_null($prix)) {
                $prix *= [1, 0.95, 0.9][array_rand([1, 0.95, 0.9])];
            } else {
                $prix = 0;
            }

            if (Plan::where('id_cons', $id_cons)
                ->where('id_trait', $id_trait)
                ->count() == 0) {
                $confirme = $this->faker->boolean(80);
                $termine =  $confirme ? $this->faker->boolean(40) : 0;

                return [
                    'dents' => $dents,
                    'desc' => $hasDesc ? $this->faker->sentences(rand(1, 2), $asText = true) : null,
                    'duree' => $hasDuree ? rand(1, 4) . [' jour.s', ' semaine.s', ' mois'][array_rand([' jour.s', ' semaine.s', ' mois'])] : null,
                    'prix' => $prix,
                    'confirme' => $confirme,
                    'termine' => $termine,
                    'id_cons' => $id_cons,
                    'id_trait' => $id_trait,
                ];
            }
        }
    }
}

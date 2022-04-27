<?php

namespace Database\Factories;

use App\Models\Examen;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Consultation;

class ExamenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Examen::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $examList = ['denture', 'paradontal'];

        while (true) {
            $nom = $examList[array_rand($examList)];
            $bloc = rand(1, 4);
            $dent = rand(1, 8);

            if ($nom == $examList[0]) {
                $zone = rand(1, 6);
            } else {
                $zone = rand(1, 4);
                $commentaire = rand(1, 9) . '/' . rand(1, 9);
            }

            $id_cons = rand(1, Consultation::count());

            // Eviter les repetitions
            if (Examen::where('nom', $nom)
                ->where('bloc', $bloc)
                ->where('dent', $dent)
                ->where('zone', $zone)
                ->where('id_cons', $id_cons)
                ->count() == 0) {
                
                return [
                    'nom' => $nom,
                    'bloc' => $bloc,
                    'dent' => $dent,
                    'zone' => $zone,
                    'commentaire' => $commentaire ?? null,
                    'id_cons' => $id_cons,
                ];
            }
        }
    }
}

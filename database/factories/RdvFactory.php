<?php

namespace Database\Factories;

use App\Models\Rdv;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;

class RdvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rdv::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $listeMotifs = ['consultation', 'traitement'];

        while (true) {
            $id_patient = rand(1, Patient::count());
            $motif = $listeMotifs[array_rand($listeMotifs)];

            // Eviter de programmer plusieurs rendez-vous pour le meme motif a un meme patient
            if (Rdv::where('id_patient', $id_patient)
                ->where('motif', $motif)
                ->count() == 0) {
                return [
                    'date' => $this->faker->dateTimeInInterval('-1 year', '+2 year'),
                    'motif' => $motif,
                    'id_patient' => $id_patient,
                ];
            }
        }
    }
}

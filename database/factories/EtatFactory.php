<?php

namespace Database\Factories;

use App\Models\Etat;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\Antecedent;

class EtatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Etat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        while (true) {
            $id_patient = rand(1, Patient::count());
            $id_antecedent = rand(1, Antecedent::count());

            // Eviter les repetitions
            if (Etat::where('id_patient', $id_patient)
                ->where('id_antecedent', $id_antecedent)
                ->count() == 0) {
                return [
                    'id_patient' => $id_patient,
                    'id_antecedent' => $id_antecedent,
                    'commentaire' => $id_antecedent == 28 ? $this->faker->realTextBetween(10, 50) : null,
                ];
            }
        }
    }
}

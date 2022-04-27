<?php

namespace Database\Factories;

use App\Models\Visite;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;

class VisiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id_patient = rand(1, Patient::count());
        
        // Dates
        if (Visite::where('id_patient', $id_patient)->count() == 0) {
            $date_1 = $this->faker->dateTimeBetween('-5 years', now());
            $date_2 = $this->faker->dateTimeBetween('-5 years', now());

           if ($date_1->getTimestamp() < $date_2->getTimestamp()) {
               $date = $date_2;
               $derniere_visite = $date_1;
            } else {
                $date = $date_1;
                $derniere_visite = $date_2;
            }
        } else {
            $derniere_visite = Visite::where('id_patient', $id_patient)->latest('date')->get('date')[0]->date;
            $date = $this->faker->dateTimeBetween($derniere_visite, 'now');
        }

        // Motif
        $isConsultation = $this->faker->boolean(35);

        return [
            'date' => $date,
            'derniere_visite' => $derniere_visite,
            'id_patient' => $id_patient,
            'motif' => $isConsultation ? 'consultation' : 'traitement',
        ];
    }
}

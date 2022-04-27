<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consultation;
use App\Models\Visite;
use Faker\Generator as Faker;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $consultations = Visite::where('motif', 'consultation')->get();

        if (!empty($consultations)) {
            foreach ($consultations as $consultation) {
                // Medicaments en cours ?
                $hasMedocs = $faker->boolean(70);

                if ($hasMedocs) {
                    $medocs_en_cours = '';
                    $nombreMedocs = rand(1, 4);

                    for ($i = 0; $i < $nombreMedocs; $i++) {
                        $medocs_en_cours .= $faker->word . ', ';
                    }

                    $medocs_en_cours .= $faker->word;
                }

                // Observations ?
                $hasObservations = $faker->boolean(80);

                Consultation::create([
                    'medocs_en_cours' => $hasMedocs ? $medocs_en_cours : null,
                    'observations' => $hasObservations ? $faker->realTextBetween(50, 150, 5) : null,
                    'frais' => rand(6, 10) . '000',
                    'id_visite' => $consultation->id,
                ]);
            }
        }
    }
}

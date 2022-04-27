<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrat;
use App\Models\Patient;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ContratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $patients = Patient::all();
        $assurances = [];

        for ($i = 0; $i < 5; $i++) {
            array_push($assurances, $faker->company() . ' Insurance');
        }

        foreach ($patients as $patient) {
            $nombreContrats = rand(0, 2);

            if ($nombreContrats == 0) {
                Contrat::create([
                    'id_patient' => $patient->id,
                    'assurance' => null,
                    'matricule' => null,
                    'employeur' => null,
                    'taux_couvert' => 0,
                    'valeur_D' => 1000,
                    'valeur_SC' => 1200,
                ]);
            } else {
                for ($i = 0; $i < $nombreContrats; $i++) {
                    $assurance = $assurances[array_rand($assurances)];
                    $employeur = $faker->company();
                    $taux_couvert = rand(5, 10) . '0';
                    $valeur_D = [750, 1000, 1200][array_rand([750, 1000, 1200])];

                    // Eviter les repetitions
                    if (Contrat::where('id_patient', $patient->id)
                        ->where('assurance', $assurance)
                        ->where('employeur', $employeur)
                        ->where('taux_couvert', $taux_couvert)
                        ->where('valeur_D', $valeur_D)
                        ->count() == 0) {
                        // Garder le meme matricule pour la modification du contrat d'un patient au sein de la meme compagnie
                        if (Contrat::where('id_patient', $patient->id)
                            ->where('assurance', $assurance)
                            ->count() == 0) {
                            $matricule = Str::random(rand(8, 12));
                        } else {
                            $matricule = Contrat::where('id_patient', $patient->id)
                                            ->where('assurance', $assurance)
                                            ->get('matricule')[0]
                                            ->matricule;
                        }
                        Contrat::create([
                            'id_patient' => $patient->id,
                            'assurance' => $assurance,
                            'matricule' => $matricule,
                            'employeur' => $employeur,
                            'taux_couvert' => $taux_couvert,
                            'valeur_D' => $valeur_D,
                            'valeur_SC' => round($valeur_D * 1.2),
                        ]);
                    }
                }
            }
        }
    }
}

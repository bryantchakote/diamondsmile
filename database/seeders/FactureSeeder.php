<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facture;
use App\Models\Visite;
use Faker\Generator as Faker;

class FactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $visites = Visite::all();

        foreach ($visites as $visite) {
            $patient = $visite->patient;
            $total = $visite->consultation->frais ?? 0;

            if (!is_null($visite->consultation) && !empty($visite->consultation->plans->where('confirme', 1))) {
                $plans = $visite->consultation->plans->where('confirme', 1);

                foreach ($plans as $plan) {
                    $total += $plan->prix ?? 0;
                }              
            }

            if ($total > 0) {
                Facture::create([
                    'total' => $total,
                    'remise' => rand(0, 4) . '0',
                    'reglee_assureur' => is_null($patient->contrats->last()->assurance) ? 1 : $faker->boolean(90),
                    'reglee_assure' => $patient->contrats->last()->taux_couvert == 100 ? 1 : $faker->boolean(90),
                    'id_visite' => $visite->id,
                ]);
            }
        }
    }
}

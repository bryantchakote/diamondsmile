<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operation;
use App\Models\Visite;
use App\Models\Patient;
use App\Models\Plan;
use Faker\Generator as Faker;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $traitements = Visite::where('motif', 'traitement');

        foreach ($traitements as $traitement) {
            $plans = [];
            $consultations = Patient::find($traitement->id_patient)->visites::where('motif', 'consultations');

            foreach ($consultations as $consultation) {
                $plans_cons = $consultation->plans;

                foreach ($plans_cons as $plan_cons) {
                    array_push($plans, $plan_cons->id);
                }
            }

            $nbre_op = rand(1, 3);

            for ($j = 0; $j < $nbre_op; $j++) {
                Operation::create([
                    'commentaire' => $faker->boolean(75) ? $faker->sentences(rand(1, 2), true) : null,
                    'id_visite' => Visite::find($traitement->id)->id,
                    'id_plan' => $plans[array_rand($plan)],
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reglement;
use App\Models\Facture;
use Faker\Generator as Faker;

class ReglementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $avance = [40, 50, 60];
        $factures = Facture::all();

        foreach ($factures as $facture) {
            $patient = $facture->visite->patient;

            $NAP = round($facture->total * (1 - $facture->remise / 100));
            $NAP_assureur = round($NAP * $patient->contrats->last()->taux_couvert / 100);
            $NAP_assure = $NAP - $NAP_assureur;

            # Reglement par la compagnie (versement unique)
            if ($facture->reglee_assureur && !is_null($patient->contrats->last()->assurance)) {
                Reglement::create([
                    'date' => $faker->dateTimeBetween($facture->visite->date, 'now'),
                    'auteur' => 'assureur',
                    'montant' => $NAP_assureur,
                    'id_facture' => $facture->id,
                ]);
            }
            
            # Reglements par le patient
            if ($patient->contrats->last()->taux_couvert != 100) {
                if ($facture->reglee_assure) {
                    $nombreReglements = rand(1, 2);

                    if ($nombreReglements == 1) {
                        Reglement::create([
                            'date' => $faker->dateTimeBetween($facture->visite->date, 'now'),
                            'auteur' => 'assure',
                            'montant' => $NAP_assure,
                            'id_facture' => $facture->id,
                        ]); 
                    } elseif ($nombreReglements == 2) {
                        $montant = round($NAP_assure * (1 - ($avance[array_rand($avance)] / 100)));

                        Reglement::create([
                            'date' => $faker->dateTimeBetween($facture->visite->date, 'now'),
                            'auteur' => 'assure',
                            'montant' => $montant,
                            'id_facture' => $facture->id,
                        ]);

                        $premierReglement = Reglement::where('id_facture', $facture->id)->where('auteur', 'assure')->get('id')[0]->id;
                        $montant = $NAP_assure - Reglement::find($premierReglement)->montant;
                        
                        Reglement::create([
                            'date' => $faker->dateTimeBetween($facture->visite->date, 'now'),
                            'auteur' => 'assure',
                            'montant' => $montant,
                            'id_facture' => $facture->id,
                        ]);
                    }
                } else {
                    $montant = round($NAP_assure * (1 - ($avance[array_rand($avance)] / 100)));

                    Reglement::create([
                        'date' => $faker->dateTimeBetween($facture->visite->date, 'now'),
                        'auteur' => 'assure',
                        'montant' => $montant,
                        'id_facture' => $facture->id,
                    ]);
                }
            }
        }
    }
}

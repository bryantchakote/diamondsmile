<?php

namespace Database\Factories;

use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Consultation;
use App\Models\Visite;

class PrescriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prescription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $produits = [
            'Efferalgan',
            'Signal fraicheur',
            'Colgate mint',
            'Dontodent charcoal',
            'Bain de bouche Nivea',
            'Fil dentaire',
            'Prothese dentaire',
            'Appareil dentaire',
        ];

        while (true) {
            $produit = $produits[array_rand($produits)];
            $id_visite = rand(1, Visite::count());

            // Eviter les repetitions
            if (Prescription::where('produit', $produit)
                ->where('id_visite', $id_visite)
                ->count() == 0) {
                // Mode d'emploi ?
                $hasModeEmploi = $this->faker->boolean(70);
                
                return [
                    'produit' => $produit,
                    'mode_emploi' => $hasModeEmploi ? $this->faker->realTextBetween(10, 50) : null,
                    'id_visite' => $id_visite,
                ];
            }
        }
    }
}

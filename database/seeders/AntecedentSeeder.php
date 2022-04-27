<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Antecedent;

class AntecedentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voidAntece
     */
    public function run()
    {
        $antecedents = [
            ['Avez-vous subi une intervention chirurgicale', null],

            ['Souffrez-vous de troubles infectueux', 'Transmissibles'],
            [null, 'Est-ce une maladie de longue durée'],

            ['Troubles cardio-vasculaires', 'Hypertension'],
            [null, 'Malformation opérée'],
            [null, 'Rhumatisme articulaire aigu'],
            [null, 'Autres'],

            ['Troubles respiratoires', 'Asthme'],
            [null, 'Autres'],

            ['Troubles neurologiques', 'Anxieté'],
            [null, 'Dépression'],
            [null, 'Autres'],

            ['Troubles sanguins', 'Trouble de la coagulation'],
            [null, 'Autres'],

            ['Etes-vous allergique', 'Aux antibiotiques'],
            [null, 'Aux anesthésiques'],
            [null, 'Autres'],

            ['Troubles digestifs', 'Ulcère'],
            [null, 'Hépatite'],
            [null, 'Autres'],

            ['Diabète', 'Etes-vous suivi'],
            [null, 'Diabète équilibré'],

            ['Autres pathologies', null],

            ['Reflexe nauséeux prononcé', null],

            ['Est-ce que les soins dentaires vous rendent nerveux', 'Légèrement'],
            [null, 'Modèrement'],
            [null, 'Sévèrement'],

            ['Commentaires', null],
        ];

        foreach ($antecedents as $antecedent) {
            Antecedent::create([
                'categorie' => $antecedent[0],
                'libelle' => $antecedent[1],
            ]);
        }
    }
}

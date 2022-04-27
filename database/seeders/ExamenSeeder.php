<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Examen;

class ExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 2500; $i++) {
            Examen::factory(1)->create();
        }
    }
}

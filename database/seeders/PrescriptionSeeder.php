<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prescription;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 600; $i++) {
            Prescription::factory(1)->create();
        }
    }
}

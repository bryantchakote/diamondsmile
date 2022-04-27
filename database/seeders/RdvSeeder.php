<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rdv;

class RdvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 157; $i++) {
            Rdv::factory(1)->create();
        }
    }
}

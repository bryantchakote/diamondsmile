<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visite;

class VisiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visite::factory(750)->create();
    }
}

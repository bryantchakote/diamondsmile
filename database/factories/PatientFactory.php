<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'sexe' => ['M', 'F'][array_rand(['M', 'F'])],
            'date_nais' => $this->faker->date(),
            'lieu_nais' => $this->faker->city(),
            'adresse' => $this->faker->streetName(),
            'tel' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'profession' => $this->faker->jobTitle(),
            'referant' => $this->faker->name(),
            'tel_referant' => $this->faker->phoneNumber(),
        ];
    }
}

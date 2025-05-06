<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RevistaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'editor_id' => '1',
            'area_id' => '2',
            'tituloRevista' => $this->faker->unique()->word(),
            'limiteArtigo' => '20',
            'ISSNRevista' => $this->faker->unique()->isbn13(),
            'periodicidade' => '1',
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EditorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'nome' => $this->faker->name(),
           'dataContratacao' => $this->faker->date(),
           'dataDemissao' => $this->faker->date(),
           'created_at' => $this->faker->date(),
           'updated_at' => $this->faker->date(),
        ];
    }
}

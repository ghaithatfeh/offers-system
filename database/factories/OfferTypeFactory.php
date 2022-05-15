<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfferType>
 */
class OfferTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name_en' => $this->faker->name,
            'name_pt' => $this->faker->name,
            'price' => $this->faker->buildingNumber,
            'description' => $this->faker->realText(200),
        ];
    }
}

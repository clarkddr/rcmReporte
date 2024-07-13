<?php

namespace Database\Factories;

use App\Models\Network;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    private static $incrementalId = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => self::$incrementalId++,
            'members_quantity' => fake()->randomNumber(2),
            'address' => fake()->streetAddress(), 
            'church_id' => 1,
            'network_id' => Network::inRandomOrder()->first()->id,
        ];
    }
}

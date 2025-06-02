<?php

declare(strict_types=1);

namespace Database\Factories\Author;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Enums\Gender;

use App\Models\Country\Country;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
    */
    public function definition(): array
    {
        return [
            'country_id' => Country::inRandomOrder()->value('id'),
            'name'       => fake()->firstName(),
            'surname'    => fake()->lastName(),
            'gender'     => fake()->randomElement(Gender::values()),
            'birth_date' => $this->faker->dateTimeBetween(startDate: '-80 years', endDate: '-20 years')->format(format: 'Y-m-d'),
        ];
    }
}

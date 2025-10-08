<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'message' => $this->faker->paragraph(4),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}

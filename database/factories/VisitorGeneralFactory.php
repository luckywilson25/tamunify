<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Visitor;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisitorGeneral>
 */
class VisitorGeneralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visitor_id' => Visitor::factory(),
            'company' => $this->faker->company,
            'purpose' => $this->faker->randomElement(['Rapat / Meeting', 'Pengiriman / Delivery', 'Maintenance', 'Interview', 'Lainnya']),
            'purpose_more' => $this->faker->optional()->sentence,
            'person_to_meet' => $this->faker->name,
            'department' => $this->faker->randomElement(['Produksi', 'Engineering', 'HRD', 'Keuangan', 'Marketing', 'IT', 'Lainnya']),
            'department_more' => $this->faker->optional()->word,
            'visit_date' => now()->toDateString(),
            'exit_date' => now()->toDateString(),
            'visit_time' => now()->format('H:i:s'),
            'exit_time' => now()->format('H:i:s'),
            'vehicle_number' => $this->faker->optional()->bothify('B #### ??'),
            'additional_info' => $this->faker->optional()->paragraph,
        ];
    }
}

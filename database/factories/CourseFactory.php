<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teacherIds = User::query()
            ->where('is_teacher', '=', true)
            ->get('id');

        $teacherIdArray = $teacherIds->map(function ($teacherId) {
            return $teacherId->id;
        });

        return [
            'name' => $this->faker->sentence(),
            'teacher_id' => $this->faker->randomElement($teacherIdArray),
            'start_time' => $this->faker->dateTimeBetween('+1 day', '+1 year')
        ];
    }
}

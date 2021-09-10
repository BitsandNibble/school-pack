<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Student::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'firstname' => $this->faker->anme(),
      'previous_class' => $this->faker->randomElement(['JSS1', 'JSS2', 'JSS3']),
      'gender' => $this->faker->randomElement(['Male', 'Female']),
      // 'date_of_birth',
      'school_id' => 'GS' . $this->faker->numerify('#####'),
      // 'email',
      'password' => Hash::make('password'),
      // 'phone_number',
      // 'profile_photo',
      'slug' => Str::random(10),

    ];
  }
}

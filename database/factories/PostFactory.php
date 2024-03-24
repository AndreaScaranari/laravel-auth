<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = fake()->text(20);
        return [
            'title' => $title,
            'slug' => STR::slug($title),
            'content' => fake()->paragraphs(15, true),
            'image' => fake()->imageUrl(250, 250, true),

        ];
    }
}

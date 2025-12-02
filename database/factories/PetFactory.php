<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * 宠物工厂类
 * 用于生成测试数据
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     * 定义模型的默认状态
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 宠物种类列表
        $species = ['Cat'];
        
        // 宠物名字前缀
        $petNames = ['Cute'];
        
        $selectedSpecies = fake()->randomElement($species);
        
        return [
            'user_id' => User::factory(), // Create user if not exists
            'title' => fake()->randomElement($petNames) . ' ' . $selectedSpecies . ' - ' . fake()->firstName(),
            'description' => fake()->paragraph(5) . ' This ' . strtolower($selectedSpecies) . ' is in excellent health, fully vaccinated, and has a gentle temperament, making it suitable for family adoption. We hope to find a caring owner who can provide it with a warm and loving home.',
            'species' => $selectedSpecies,
            'age' => fake()->numberBetween(2, 60), // 2-60 months
            'photo' => 'pets/58P48h5bN5Du1mpyJ1k18t6IMBSP4JrWM5YqqfHj.png', // Default pet photo path
            'is_visible' => fake()->boolean(90), // 90% chance of being visible
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * 数据库种子类
 * 用于填充测试数据
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 填充数据库数据
     */
    public function run(): void
    {
        // 创建第一个测试用户
        $user1 = User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('123456'),
        ]);

        // 创建第二个测试用户
        $user2 = User::factory()->create([
            'name' => 'ZhangSan',
            'email' => 'zhangsan@example.com',
            'password' => Hash::make('123456'),
        ]);

        // 创建第三个测试用户
        $user3 = User::factory()->create([
            'name' => 'LiSi',
            'email' => 'lisi@example.com',
            'password' => Hash::make('123456'),
        ]);

        // 为第一个用户创建一条宠物信息
        Pet::factory()->create([
            'user_id' => $user1->id,
        ]);

        $this->command->info('数据库种子数据填充完成！');
        $this->command->info('测试账号1: test@test.com / 123456');
        $this->command->info('测试账号2: zhangsan@example.com / 123456');
        $this->command->info('测试账号3: lisi@example.com / 123456');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public const COUNT = 10;
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < self::COUNT; $i++) {
            User::factory()->create(['email' => "test{$i}@gmail.com"]);
        }
    }
}

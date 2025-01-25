<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public const COUNT = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $creator) {
            Task::factory(self::COUNT)->create(['creator_id' => $creator->id]);
        }
    }
}

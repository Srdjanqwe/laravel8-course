<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = max((int)$this->command->ask('How many user would you like?',4),1);
        \App\Models\User::factory()->newUser()->create();
        \App\Models\User::factory($usersCount)->create();

    }
}

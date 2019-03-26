<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int)$this->command->ask('How many items do you need?', 10);
        $this->command->info("Creating {$count} items");

        $users = factory(App\Models\User::class, $count)->create();
        $this->command->info('Users Created');
    }
}

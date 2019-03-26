<?php

use Illuminate\Database\Seeder;

class PhonebookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $count = (int)$this->command->ask('How many items do you need?', 100);
        $this->command->info("Creating {$count} items");

        $users = factory(App\Models\Phonebook::class, $count)->create();
        $this->command->info('Phonebook Records Created');
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomersTableSeed::class);
        $this->command->info('Customer table seeded.');

        $this->call(TicketsTableSeed::class);
        $this->command->info('Tickets table seeded.');
    }
}

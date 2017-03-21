<?php

use Illuminate\Database\Seeder;

class TicketsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ticket::class, 10)->create();
    }
}

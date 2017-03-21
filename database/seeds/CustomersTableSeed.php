<?php

use Illuminate\Database\Seeder;

class CustomersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('customers')->delete();
        factory(App\Customer::class, 10)->create()->each(function($customer) {
            factory(App\Ticket::class)->create(['customer_id' => $customer->id]);
        });
    }
}

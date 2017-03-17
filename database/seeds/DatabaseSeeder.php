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
        // Clear table first
        DB::table('customers')->truncate();
        for ($i = 0; $i < 10; $i++) {
            $date = date("Y-m-d H:i:s");
            DB::table('customers')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}

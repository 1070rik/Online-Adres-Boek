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
        $faker = Faker\Factory::create('nl_NL');

        for ($i = 0; $i < 200; $i++){
        	$address = $faker->address;

        	print_r($address);
        }
    }
}

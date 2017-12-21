<?php

use Illuminate\Database\Seeder;
use AdresBoek\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = str_random(10);
        User::create([
            'uniqid' => uniqid(),
            'email' => 'admin@admin.com',
            'password' => bcrypt($password),
            'admin' => 1,
            'firstVisit' => 0
        ]);
        echo "Admin user with email admin@admin.com and password " . $password . " has been succesfully created \n";
    }
}

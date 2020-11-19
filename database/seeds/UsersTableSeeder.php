<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user = User::create([

        	'name' => 'Hamada',
        	'email' => 'test1@test.com',
        	'password' => bcrypt('123456'),



        ]);

        $user->attachRole('superadministrator');
    }
}

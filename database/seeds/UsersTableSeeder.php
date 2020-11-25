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
        	'phone' => '0102020',
        	'address' => 'haram',
        	'gender' => 'm',
        	'age' => '22',
        	'image' => 'nnn',



        ]);

        $user->attachRole('superadministrator');
    }
}

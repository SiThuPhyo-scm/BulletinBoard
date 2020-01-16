<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('Admin123'),
                'profile' => 'profile',
                'type' => '0',
                'phone' => '09970563411',
                'address' => 'Hlaing Township, Yangon',
                'dob' => '1997/05/15',
                'create_user_id' => '1',
                'updated_user_id' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}

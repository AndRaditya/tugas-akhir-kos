<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'roles_id' => 1,
                'name' => 'Andreas Raditya',
                'email' => 'raditya@gmail.com',
                'password' => '$2a$12$DKF6xWBbppVAfpuaTSN1weyGBV9Zv1j1EVd43kVSxtI9wOtAUUpy.',
                'phone_number' => '0812345678',
                'rekening' => '1234567',
                'bank' => 'Mandiri',
                'created_at' => '2023-03-04 16:04:00',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'roles_id' => 2,
                'name' => 'Raditya',
                'email' => 'aryatama@gmail.com',
                'password' => '$2a$12$DKF6xWBbppVAfpuaTSN1weyGBV9Zv1j1EVd43kVSxtI9wOtAUUpy.',
                'phone_number' => '0812345678',
                'rekening' => NULL,
                'bank' => NULL,
                'created_at' => '2023-03-04 16:04:00',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
    }
}
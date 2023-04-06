<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users_role')->delete();

        \DB::table('users_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Pengelola',
                'created_at' => '2019-05-09 21:55:15',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Customer',
                'created_at' => '2019-05-09 21:55:15',
                'updated_at' => NULL,
            ),
        ));
    }
}

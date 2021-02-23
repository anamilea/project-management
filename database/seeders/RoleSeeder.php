<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([[
            'id' => 1,
            'name' => 'Admin',
            'guard_name' => 'web'
        ],
        [
            'id' => 2,
            'name' => 'User',
            'guard_name' => 'web'
        ]]
    );
    }
}

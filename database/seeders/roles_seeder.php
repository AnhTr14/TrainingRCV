<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class roles_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupRoles = ['Admin', 'Editor', 'Reviewer'];
        foreach ($groupRoles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }
    }
}

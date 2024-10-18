<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class mst_users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupRoles = ['Admin', 'Editor', 'Reviewer'];

        for ($i = "A"; $i <= "X"; ++$i) {
            DB::table('mst_users')->insert([
                'name' => "Le ".$i,
                'email' => fake()->unique()->email,
                'password' =>Hash::make("1234"),
                'is_active' => rand(0, 1),
                'is_delete' => rand(0, 1),
                'group_role' => $groupRoles[array_rand($groupRoles)],
                'created_at' => fake()->date
            ]);
        }
    }
}

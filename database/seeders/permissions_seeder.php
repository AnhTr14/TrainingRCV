<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class permissions_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['View', 'Create', 'Edit', 'Delete'];
        $screens = ['User', 'Product', 'Role'];
        foreach ($actions as $action) {
            foreach ($screens as $screen) {
                DB::table('permissions')->insert([
                    'name' => $action . " " . $screen,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}

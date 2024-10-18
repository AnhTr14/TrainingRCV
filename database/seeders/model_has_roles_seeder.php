<?php

namespace Database\Seeders;

use App\Models\MstUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class model_has_roles_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = MstUser::all();
        $countRole = Role::count();

        foreach($users as $user) {
            $roleId = random_int(1, $countRole);
            DB::table('model_has_roles')->insert([
                'role_id' => $roleId,
                'model_type' => 'App\\Models\\MstUser',
                'model_id' => $user->id,
            ]);
        }
    }
}

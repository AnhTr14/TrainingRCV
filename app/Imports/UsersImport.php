<?php

namespace App\Imports;

use App\Models\MstUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     * @param Failure[] $failures
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    protected $failures;

    public function __construct(array &$failures)
    {
        $this->failures = &$failures;
    }

    public function model(array $row)
    {
        $email = trim($row['email']);
        $name = trim($row['name']);
        $role = trim($row['role']);

        $user = MstUser::where('email', $email)->first();

        if (!$user) {
            $user = MstUser::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make("1234"),
                'is_active' => 1,
                'is_delete' => 0,
            ]);
            $user->assignRole($role);
        } else {
            $user->name = $name;
            $user->update();
            $user->syncRoles($role);
        }
    }

    public function rules(): array
    {
        $a =  [
            'email' => 'required|regex:/^[^@]+@[^@]+\.[^@]+$/',
            'name' => 'required',
            'role' => 'required|exists:roles,name'
        ];
        return $a;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = $failure;
        }
    }
}

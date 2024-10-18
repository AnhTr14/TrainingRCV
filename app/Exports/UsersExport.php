<?php

namespace App\Exports;

use App\Models\MstUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $query = MstUser::select('name', 'email', 'is_active', 'last_login_at');
        return $query;
    }

    public function map($row): array
    {
     $name = explode(" ", $row->name);
     $first_name = $name[0];
     $last_name = !empty($name[1]) ? $name[1] : null;
        return [
            $first_name,
            $last_name,
            $row->email,
            $row->is_active ? 'Active' : 'Inactive',
            $row->last_login_at
        ];
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Status',
            'Last Login',
        ];
    }
}

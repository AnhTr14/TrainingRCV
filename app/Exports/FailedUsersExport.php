<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class FailedUsersExport implements FromArray, WithHeadings
{
    /**
     * @return \Illuminate\Support\Array
     */
    protected $data;
    protected $failures;


    public function __construct(Collection $data, array $failures)
    {
        $this->data = $data;
        $this->failures = $failures;
    }

    public function array(): array
    {

        $array = [];
        $index = 1;
        foreach ($this->data as $item) {
            ++$index;
            $error = "";
            foreach ($this->failures as $failure) {
                if ($failure->row() == $index) {
                    $error = $failure->errors();
                    break;
                }
            }
            $array[] = [
                'Name' => $item['name'],
                'Email' => $item['email'],
                'Role' => $item['role'],
                'Error' => $error,
            ];
        }

        return $array;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Role',
            'Error'
        ];
    }
}

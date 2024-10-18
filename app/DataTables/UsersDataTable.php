<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\MstUser;

class UsersDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)       
            ->toJson();
    }

    public function query(MstUser $model)
    {
        // return $model->select('id', 'name', 'email', 'group_role', 'is_active');
        return $model->select('name', 'email');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('usersTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip');
    }

    protected function getColumns()
    {
        // return [
        //     '#',
        //     'Họ tên',
        //     'Email',
        //     'Nhóm',
        //     'Trạng thái',
        // ];
        return [
            'Họ tên',
            'Email',
        ];
    }
}

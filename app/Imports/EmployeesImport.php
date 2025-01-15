<?php

namespace App\Imports;

use App\Models\TruEmployees;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TruEmployees([
            'emp_id'  => $row[1],
            'emp_name' => $row[5],
            'start_date' => $row[6],
            'work_exp' => $row[7],
            'bus_group' => $row[10],
            'position' => $row[11],
            'agency' => $row[12],
            'department' => $row[13],
            'dept' => $row[14],
        ]);
    }
}

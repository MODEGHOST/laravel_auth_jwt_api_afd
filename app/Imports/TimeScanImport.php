<?php

namespace App\Imports;

use App\Models\TimeScanModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TimeScanImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function startRow(): int
    {
       return 2;
    }

    public function model(array $row)
    {
        return new TimeScanModel([
            'index' => $row[0], 
            'pin' => $row[1], 
            'ename' => $row[2], 
            'time' => $row[3], 
            'state' => $row[4], 
            'verification' => $row[5], 
            'work_code' => $row[6], 
            'reserved' => $row[7], 
            'device' => $row[8], 
        ]);
    }
}

<?php

namespace App\Imports;
use App\Masterbobot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportBobot implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Masterbobot([
            'kode_kpi'      => $row[0],
            'kode_unit'     => $row[1],
            'tahun'         => $row[3], 
            'bulan'         => $row[4],
            'bobot'         => $row[5]
            
            
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}

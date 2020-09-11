<?php

namespace App\Imports;
use App\Bobot;
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


    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}

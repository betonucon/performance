<?php

namespace App\Imports;

use App\Target;
use Maatwebsite\Excel\Concerns\ToModel;

class TargetkerjaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Target([
            //
        ]);
    }
}

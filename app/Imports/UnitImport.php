<?php

namespace App\Imports;

use App\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UnitImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
            
            // $unitt      = Unit::where('kode',$row[0])->first();
            // $unitt->kode_unit = $row[1];
            // $unitt->save();
            
            return $cek=Unit::where('kode',$row[0])->update([
                'kode_unit'                   => $row[1],
                
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

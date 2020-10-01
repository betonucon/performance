<?php

namespace App\Imports;
use App\Masterbobot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BobotImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek=Masterbobot::where('kode_unit',$row[1])->where('kode_kpi',$row[0])->where('tahun',$row[2])->where('bulan',$row[3])->count();
        if($cek>0){
            $data         = Masterbobot::where('kode_unit',$row[1])->where('kode_kpi',$row[0])->where('tahun',$row[2])->where('bulan',$row[3])->first();
            $data->bobot  = $row[4];
            $data->save();
        }else{
            return new Masterbobot([
                'kode_kpi'      => $row[0],
                'kode_unit'     => $row[1],
                'tahun'         => $row[2], 
                'bulan'         => $row[3],
                'bobot'         => $row[4]
                
                
            ]);
        }
        
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}

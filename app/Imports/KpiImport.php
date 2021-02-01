<?php

namespace App\Imports;

use App\Kpi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KpiImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek=Kpi::where('kode_kpi',$row[0])->where('tahun',$row[6])->count();
        if($cek>0){
            $data         = Kpi::where('kode_kpi',$row[0])->where('tahun',$row[6])->first();
            $data->kpi  = $row[1];
            $data->rumus_capaian  = $row[4];
            $data->rumus_akumulasi  = $row[5];
            $data->save();
        }else{
            return new Kpi([
                'kode_kpi'              => $row[0],
                'kpi'                   => $row[1],
                'tahun'                 => $row[6],
                'satuan'                => $row[3], 
                'rumus_capaian'         => $row[4],
                'rumus_akumulasi'       => $row[5],
                'deskripsi'             => $row[2],
                'keterangan'            => $row[2],
                'waktu'                 => date('Y-m-d H:i:s'),
                
                
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

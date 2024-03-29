<?php

namespace App\Imports;

use App\Deployment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DeploymentImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek=Deployment::where('kode_unit',$row[0])->where('kode_kpi',$row[1])->where('tahun',$row[4])->count();
        
        if($cek>0){
            $data                     = Deployment::where('kode_unit',$row[0])->where('kode_kpi',$row[1])->where('tahun',$row[4])->first();
            $data->target_tahunan     = $row[2];
            $data->bobot_tahunan      = $row[3];
            $data->rumus_capaian      = rumus_capaian($row[1],$row[4]);
            $data->rumus_akumulasi    = rumus_akumulasi($row[1],$row[4]);
            $data->kode_unit_tingkat  = $row[5];
            $data->pilar  = $row[8];
            $data->updated_at  = date('Y-m-d H:i:s');
            $data->save();
        }else{
            return new Deployment([
                'kode_unit'         => $row[0],
                'kode_kpi'          => $row[1],
                'target_tahunan'    => $row[2],
                'bobot_tahunan'     => $row[3],
                'tahun'             => $row[4],
                'rumus_akumulasi'   => rumus_akumulasi($row[1],$row[4]),
                'rumus_capaian'     => rumus_capaian($row[1],$row[4]),
                'id_kpi_unix'       => $row[1].$row[4],
                'kode_unit_tingkat' => $row[5],
                'updated_at'         => date('Y-m-d H:i:s'),
                'level' => $row[6],
                'sts' => $row[7],
                'status_id' => 1,
                'pilar'     => $row[8],
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

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
            $data->rumus_capaian      = $kpii['rumus_capaian'];
            $data->rumus_akumulasi    = $kpii['rumus_akumulasi'];
            $data->kode_unit_tingkat  = $row[5];
            $data->update_at  = date('Y-m-d H:i:s');
            $data->save();
        }else{
            return new Deployment([
                'kode_unit'         => $row[0],
                'kode_kpi'          => $row[1],
                'target_tahunan'    => $row[2],
                'bobot_tahunan'     => $row[3],
                'tahun'             => $row[4],
                'rumus_akumulasi'   => rumus_akumulasi($row[1]),
                'rumus_capaian'     => rumus_capaian($row[1]),
                'id_kpi_unix'       => $row[1].$row[4],
                'kode_unit_tingkat' => $row[5],
                'update_at'         => date('Y-m-d H:i:s'),
                'level' => $row[6],
                'sts' => $row[7],
                'status_id' => 1,
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

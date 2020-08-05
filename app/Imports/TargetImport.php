<?php

namespace App\Imports;

use App\Deployment;
use App\Target;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TargetImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $cek=Deployment::where('kode_unit',$row['0'])->where('kode_kpi',$row['2'])->first();
        $tarex=explode('.',$row[4]);
        $realex=explode('.',$row[5]);
        if($tarex[1]==''){$nilaitarget=$row[4];}else{$nilaitarget=$tarex[0].'.'.substr($tarex[1],0,2);}
        if($realex[1]==''){$nilairealisasi=$row[5];}else{$nilairealisasi=$realex[0].'.'.substr($realex[1],0,2);}

        if($row['0']=='all'){
            $get_deploy             =Deployment::where('kode_kpi',$row['1'])->where('tahun',$row['2'])->get();
            
            foreach($get_deploy as $get){
                $deploy             =Deployment::where('id',$get['id'])->first();
                $deploy->sts        = 1;
                $deploy->status_id  = 4;
                $deploy->save();

                if($deploy){
                    
                    $cektarget =Target::where('deployment_id',$deploy['id'])->where('bulan',$row[3])->count();
                    if($cektarget>0){
                        $target             =Target::where('deployment_id',$deploy['id'])->where('bulan',$row[3])->first();
                        $target->target     = $nilaitarget;
                        $target->realisasi     = $nilairealisasi;
                        $target->save();
                    }else{
                        $target             = new Target;
                        $target->deployment_id     = $deploy['id'];
                        $target->bulan     = $row[3];
                        $target->target     = $nilaitarget;
                        $target->realisasi     = $nilairealisasi;
                        $target->status_realisasi     = 1;
                        $target->save();
                    }
                    
                }
            }


        }
        
        
        else{
            $cekdep =Deployment::where('kode_unit',$row['0'])->where('kode_kpi',$row['1'])->where('tahun',$row['2'])->count();
            if($cekdep>0){
                $deploy             =Deployment::where('kode_unit',$row['0'])->where('kode_kpi',$row['1'])->where('tahun',$row['2'])->first();
                $deploy->sts        = 1;
                $deploy->status_id  = 4;
                $deploy->save();

                if($deploy){
                    
                    $cektarget =Target::where('deployment_id',$deploy['id'])->where('bulan',$row[3])->count();
                    if($cektarget>0){
                        $target             =Target::where('deployment_id',$deploy['id'])->where('bulan',$row[3])->first();
                        $target->target     = $nilaitarget;
                        $target->realisasi     = $nilairealisasi;
                        $target->save();
                    }else{
                        $target             = new Target;
                        $target->deployment_id     = $deploy['id'];
                        $target->bulan     = $row[3];
                        $target->target     = $nilaitarget;
                        $target->realisasi     = $nilairealisasi;
                        $target->status_realisasi     = 1;
                        $target->save();
                    }
                    
                }
            }else{
                
            }
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

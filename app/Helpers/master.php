<?php
ini_set('max_execution_time', 30000);
function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}

function color($id){
    if($id==1){
        $color="#e2e2ca";
    }
    if($id==2){
        $color="#fff";
    }
    if($id==3){
        $color="#f9f4fb";
    }

    return $color;
}
function bulan_validasi($b)
{
   if($b>11){
       $bulan=1;
   }else{
       $bulan=$b+1;
   }

   if($bulan==1){
       $bul=='01';
   }
   if($bulan==2){
       $bul=='02';
   }
   if($bulan==3){
       $bul=='03';
   }
   if($bulan==4){
       $bul=='04';
   }
   if($bulan==5){
       $bul=='05';
   }
   if($bulan==6){
       $bul=='06';
   }
   if($bulan==7){
       $bul=='07';
   }
   if($bulan==8){
       $bul=='08';
   }
   if($bulan==9){
       $bul=='9';
   }
   if($bulan==10){
       $bul==10;
   }
   if($bulan==11){
       $bul==11;
   }
   if($bulan==12){
       $bul==12;
   }
   return $bul;
}

function bulan_db($b)
{
   if($b>9){
       $bulan=$b;
   }else{
       $bulan='0'.$b;
   }

   return $bulan;
}

function bul($bulan)
{
   Switch ($bulan){
      case '1' : $bulan="Januari";
         Break;
      case '2' : $bulan="Februari";
         Break;
      case '3' : $bulan="Maret";
         Break;
      case '4' : $bulan="April";
         Break;
      case '5' : $bulan="Mei";
         Break;
      case '6' : $bulan="Juni";
         Break;
      case '7' : $bulan="Juli";
         Break;
      case '8' : $bulan="Agustus";
         Break;
      case '9' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}

function cek_role($id){
    if($id==1){
        return 'Admin';
    }
    if($id==2){
        return 'PIC';
    }
    if($id==1){
        return 'Pimpinan';
    }
}
function tgl($tgl=null){
    if($tgl=='' || $tgl==0){
        $data=0;
    }else{
        $data=date('d/m/y',strtotime($tgl));
    }
    
    return $data;
}
function ttd(){
    
    $t=date('d');
    $m=bulan(date('m'));
    $y=date('Y');

    $data=$t.'  '.$m.' '.$y;

    return $data;
}

function validasi_tanggal(){
    $data=App\Tanggalvalidasi::orderBy('tahun','Asc')->get();

    return $data;
}
function pimpinan(){
    $data=App\Pengaturan::where('id',1)->first();

    return $data['value'];
}

function tgl_validasi($tahun){
    $data=App\Tanggalvalidasi::where('tahun',$tahun)->first();

    return $data['tanggal'];
}


function array_mandatori(){
    $data  = array_column(
        App\Deployment::select('kode_unit')->where('sts', 1)->groupBy('kode_unit')
        ->get()
        ->toArray(),'kode_unit'
     );
     return $data;
}

function array_kode($kode,$tahun,$bulan){
    
        if(Auth::user()['role_id']==1){
            $cek=App\Deployment::where('kode_unit',$kode)->where('sts', 0)->where('tahun',$tahun)->count();
            $data  = array_column(
                App\Deployment::where('kode_unit',$kode)->where('sts', 0)->where('tahun',$tahun)
                ->get()
                ->toArray(),'id'
            );

            if($cek>0){
                $realisasi=App\Target::whereIn('deployment_id',$data)->where('tgl_validasi_atasan','!=',null)->where('bulan',$bulan)->count();
                if($cek==$realisasi){
                    $nilai=1;
                }else{
                    $nilai=0;
                }
            }else{
                $nilai=0;
            }
        }

        if(Auth::user()['role_id']==2){
            $cek=App\Deployment::where('kode_unit',$kode)->where('sts', 0)->where('tahun',$tahun)->count();
            $data  = array_column(
                App\Deployment::where('kode_unit',$kode)->where('sts', 0)->where('tahun',$tahun)
                ->get()
                ->toArray(),'id'
            );

            if($cek>0){
                $realisasi=App\Target::whereIn('deployment_id',$data)->where('tgl_validasi_atasan','!=',null)->where('bulan',$bulan)->count();
                if($cek==$realisasi){
                    $nilai=1;
                }else{
                    $nilai=0;
                }
            }else{
                $nilai=0;
            }
        }

        if(Auth::user()['role_id']==3){
            $cek=App\Deployment::where('kode_unit',$kode)->where('sts', 0)->where('tahun',$tahun)->count();
            $data  = array_column(
                App\Deployment::where('kode_unit',$kode)->where('sts', 0)->where('tahun',$tahun)
                ->get()
                ->toArray(),'id'
            );

            if($cek>0){
                $realisasi=App\Target::whereIn('deployment_id',$data)->where('tgl_validasi_atasan','!=',null)->where('bulan',$bulan)->count();
                if($cek==$realisasi){
                    $nilai=1;
                }else{
                    $nilai=0;
                }
            }else{
                $nilai=0;
            }
        }
     return $nilai;
}

function persen($tahun,$bulan){
    $cek=App\Deployment::where('sts',0)->where('tahun',$tahun)->count();
    $data  = array_column(
        App\Deployment::where('sts',0)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

    if($cek>0){
        $realisasi=App\Target::whereIn('deployment_id',$data)->where('status_realisasi',2)->where('bulan',$bulan)->count();
        if($cek==$realisasi){
            $nilai=$realisasi;
        }else{
            $nilai=$cek;
        }
            
        
    }else{
        $nilai=0;
    }
     return $realisasi;
}

function array_unit_user(){
    
    $data  = array_column(
        App\Unit::where('nik', Auth::user()['nik'])
        ->get()
        ->toArray(),'kode'
     );

     foreach($data as $dat){
         echo'<option value="'.$dat.'">'.cek_unit($dat)['nama'].'</option>';
         if(cek_unit($dat)['unit_id']==5){
             $datasub=App\Unit::where('kode_unit',$dat)->get();
             foreach($datasub as $sub){
                echo'<option value="'.$sub['kode'].'">- '.$sub['nama'].'</option>';
                $datadiv=App\Unit::where('kode_unit',$sub['kode'])->get();
                foreach($datadiv as $div){
                    echo'<option value="'.$div['kode'].'">&nbsp;&nbsp;- '.$div['nama'].'</option>';
                }
             }
         }

         if(cek_unit($dat)['unit_id']==1){
             $datadiv=App\Unit::where('kode_unit',$dat)->get();
             foreach($datadiv as $div){
                echo'<option value="'.$div['kode'].'">&nbsp;&nbsp;- '.$div['nama'].'</option>';
                
             }
         }
     }
}

function array_unit_atasan_subdit($atasan){
    $data  = array_column(
        App\Unit::where('kode_unit', $atasan)->orWhere('kode',$atasan)
        ->get()
        ->toArray(),'kode'
     );

     return $data;
}

function array_deployment($kode,$tahun){
    $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     return $data;
}
function cek_array_unit_atasan_subdit($atasan){
    $data  =App\Unit::where('kode_unit', $atasan)->orWhere('kode',$atasan)
        ->count();

     return $data;
}

function bobot_bulanan($kode_unit,$kode_kpi,$tahun,$bulan){
    $data=App\Masterbobot::where('kode_kpi',$kode_kpi)->where('kode_unit',$kode_unit)->where('tahun',$tahun)->where('bulan',$bulan)->first();

    return $data['bobot'];
}
function subdit(){
    $datasub=App\Unit::where('unit_id',1)->get();
    foreach($datasub as $dat){
        echo'<option value="'.$dat['kode'].'">&nbsp;&nbsp;- '.$dat['nama'].'</option>';
    }
    
}
function array_unit_atasan(){
    if(pimpinan()==Auth::user()['nik']){
        $data  = array_column(
            App\Unit::whereIn('unit_id',[3,5,1])
            ->get()
            ->toArray(),'kode'
         );
    }else{
        $data  = array_column(
            App\Unit::where('nik_atasan', Auth::user()['nik'])
            ->get()
            ->toArray(),'kode'
         );
    }
    

     foreach($data as $dat){
         echo'<option value="'.$dat.'">'.cek_unit($dat)['nama'].'</option>';
         if(cek_unit($dat)['unit_id']==5){
             $datasub=App\Unit::where('kode_unit',$dat)->get();
             foreach($datasub as $sub){
                echo'<option value="'.$sub['kode'].'">&nbsp;&nbsp;- '.$sub['nama'].'</option>';
                $datadiv=App\Unit::where('kode_unit',$sub['kode'])->get();
                foreach($datadiv as $div){
                    echo'<option value="'.$div['kode'].'">&nbsp;&nbsp;&nbsp;&nbsp;- '.$div['nama'].'</option>';
                }
             }
         }

         if(cek_unit($dat)['unit_id']==1){
             $datadiv=App\Unit::where('kode_unit',$dat)->get();
             foreach($datadiv as $div){
                echo'<option value="'.$div['kode'].'">&nbsp;&nbsp;&nbsp;&nbsp;- '.$div['nama'].'</option>';
                
             }
         }
     }
}

function array_user(){
    if(Auth::user()['role_id']==2){
        $data  = array_column(
           App\Unit::where('nik', Auth::user()['nik'])
           ->get()
           ->toArray(),'kode'
        );
     }
     if(Auth::user()['role_id']==3){
        $data  = array_column(
            App\Unit::where('nik_atasan', Auth::user()['nik'])
            ->get()
            ->toArray(),'kode'
         );
     }
     if(Auth::user()['role_id']==1){
        $data  = array_column(
            App\Unit::whereIn('unit_id',[3,5,1])
            ->get()
            ->toArray(),'kode'
         );
     }

     return $data;
}



function array_deploymen_target_mandatori($tahun,$bulan){
    $data  = array_column(
        App\Deployment::where('sts',1)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->where('target','!=',0)->count();
     return $target;
}

function array_deploymen_target($kode,$tahun,$bulan){
    $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('sts',0)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->where('target','!=',0)->count();
     
     return $target;
    // $data  = App\Deployment::where('kode_unit',$kode)->where('sts',0)->where('tahun',$tahun)->count();
    // return $data;
}
function array_deploymen_target_val($kode,$tahun,$bulan){
    $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('sts',0)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->count();
     return $target;
}
function array_deploymen_realisasi($kode,$tahun,$bulan){
    $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('sts',0)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->where('target','!=',0)->where('realisasi','!=',0)->count();
     return $target;
}

function array_deploymen_realisasi_mandatori($tahun,$bulan){
    $data  = array_column(
        App\Deployment::where('sts',1)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->where('target','!=',0)->where('realisasi','!=',0)->count();
     return $target;
}

function cek_validasi_atasan($kode,$tahun,$bulan){
     $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('sts',0)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->where('tgl_validasi_atasan','!=',null)->count();
     return $target;
}
function cek_validasi_atasan_mandatori($tahun,$bulan){
     $data  = array_column(
        App\Deployment::where('sts',1)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
     );

     $target=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->where('tgl_validasi_atasan','!=',null)->count();
     return $target;
}

function tgl_validasi_atasan($kode=null,$tahun=null,$bulan=null){
    $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('sts',0)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
    );

    $cek=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->count();
    if($cek>0){
        $tgl=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->orderBy('id','desc')->firstOrFail();
        return $tgl['tgl_validasi_atasan'];
    }else{
        return 0;
    }
    
}

function tgl_validasi_atasan_mandatori($tahun,$bulan){
    $data  = array_column(
        App\Deployment::where('sts',1)->where('tahun',$tahun)
        ->get()
        ->toArray(),'id'
    );

    $tgl=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->orderBy('id','desc')->firstOrFail();
    return $tgl['tgl_validasi_atasan'];
}

function deployment(){
    $data=App\Deployment::orderBy('kode_kpi','Asc')->get();

    return $data;
}

function deployment_non(){
    $data=App\Deployment::where('sts',0)->orderBy('kode_kpi','Asc')->get();

    return $data;
}

function deployment_non_user($kode=null,$tahun=null){
    if($kode!=''){
        $data=App\Deployment::where('sts',0)->where('kode_unit',$kode)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',0)->whereIn('kode_unit',array_user())->where('tahun',date('Y'))->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}

function validasi_all($tahun=null){
    if($tahun==''){
        $thn=date('Y');
    }else{
        $thn=$tahun;
    }
    if(Auth::user()['role_id']==1){
        $data=App\Deployment::where('sts',0)->where('status_id',3)->where('tahun',$thn)->count();
    }

    if(Auth::user()['role_id']==3){
        $data=App\Deployment::where('sts',0)->where('status_id',2)->whereIn('kode_unit',array_user())->where('tahun',$thn)->count();
    }
    return $data;  
}

function deployment_target($kode=null,$tahun=null){
    if($kode!=''){
        $data=App\Deployment::where('sts',0)->where('kode_unit',$kode)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',0)->whereIn('kode_unit',array_user())->where('tahun',date('Y'))->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}
function deployment_realisasi($kode=null,$tahun=null){
    if($kode!=''){
        $data=App\Deployment::where('sts',0)->where('status_id',4)->where('kode_unit',$kode)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',0)->where('status_id',4)->whereIn('kode_unit',array_user())->where('tahun',date('Y'))->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}

function deployment_realisasi_atasan($kode=null,$tahun=null,$pilar=null){
    if($kode!=''){
        $data=App\Deployment::where('status_id',4)->where('kode_unit',$kode)->where('pilar',$pilar)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('status_id',4)->where('kode_unit',$kode)->where('pilar',$pilar)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}
function cek_deployment_realisasi_atasan($kode=null,$tahun=null){
    if($kode!=''){
        $data=App\Deployment::where('status_id',4)->where('kode_unit',$kode)->where('tahun',$tahun)->count();
    }else{
        $data=App\Deployment::where('status_id',4)->where('kode_unit',$kode)->where('tahun',$tahun)->count();
    }
    

    return $data;
}

function deployment_realisasi_atasan_mandatori($tahun=null){
    if($tahun!=''){
        $data=App\Deployment::where('sts',1)->where('status_id',4)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',1)->where('status_id',4)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}

function deployment_mandatori_user($kode=null,$tahun=null){
    if($kode!=''){
        $data=App\Deployment::where('sts',1)->where('status_id',4)->where('kode_unit',$kode)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',1)->where('status_id',4)->whereIn('kode_unit',array_mandatori())->where('tahun',date('Y'))->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}
function deployment_mandatori_capaian($tahun=null){
    if($tahun!=''){
        $data=App\Deployment::where('sts',1)->where('status_id',4)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',1)->where('status_id',4)->where('tahun',date('Y'))->orderBy('kode_kpi','Asc')->get();
    }
    

    return $data;
}


function deployment_mandatori($kode=null,$tahun=null){
    if($kode!=''){
        $data=App\Deployment::where('sts',1)->where('kode_unit',$kode)->where('tahun',$tahun)->orderBy('kode_kpi','Asc')->get();
    }else{
        $data=App\Deployment::where('sts',1)->where('tahun',date('Y'))->orderBy('kode_kpi','Asc')->get();
    }
    return $data;
}
function kpi(){
    $data=App\Kpi::all();

    return $data;
}
function cek_kpi($kode,$tahun){
    $data=App\Kpi::where('kode_kpi',$kode)->where('tahun',$tahun)->first();

    return $data;
}

function cek_bobot($kode,$id,$tahun,$bulan){
    $kpi  = App\Deployment::where('id',$id)->first();
    $data=App\Masterbobot::where('kode_kpi',$kpi['kode_kpi'])->where('kode_unit',$kode)->where('tahun',$tahun)->where('bulan',$bulan)->first();

    return $data['bobot'];
}
function cek_nik($nik){
    $data=App\User::where('nik',$nik)->first();

    return $data['name'];
}

function level(){
    $data=App\Level::all();

    return $data;
}

function cek_level($id){
    $data=App\Level::where('id',$id)->first();

    return $data['name'];
}

function capaian($id){
    $data=App\Capaian::where('id',$id)->first();

    return $data['name'];
}

function cek_capaian($id){
    $data=App\Capaian::where('id',$id)->first();

    return $data['name'];
}

function status_realisasi($id){
    $data=App\Status::where('id',$id)->first();
    $text='Realisasi';
    if(is_null($id) || $id==''){
        $sts='Menunggu Penyelesaian Target';
    }elseif($id==1){
        $sts=$data['name'].' '.$text;
    }else{
        $sts=$data['name'];
    }
    

    return $sts;
}

function icon_status($id){
    $data=App\Status::where('id',$id)->first();
    $text='Target';
    if($id==1){
        $sts='<span class="label label-success">'.$data['name'].' '.$text.'</span>';
    }
    if($id==2){
        $sts='<span class="label label-warning">'.$data['name'].'</span>';
    }
    if($id==3){
        $sts='<span class="label label-warning">'.$data['name'].'</span>';
    }
    if($id==4){
        $sts='<span class="label label-primary">'.$data['name'].'</span>';
    }
    
    

    return $sts;
}
function icon_status_realisasi($id){
    $data=App\Status::where('id',$id)->first();
    $text='Realisasi';
    if(is_null($id) || $id==''){
        $sts='<span class="label label-primary">Realisasi</span>';
    }
    if($id==1){
        $sts='<span class="label label-primary">Realisasi</span>';
    }
    if($id==2){
        $sts='<span class="label label-warning">'.$data['name'].'</span>';
    }
    if($id==3){
        $sts='<span class="label label-warning">'.$data['name'].'</span>';
    }
    if($id==4){
        $sts='<span class="label label-primary">'.$data['name'].'</span>';
    }
    

    return $sts;
}

function status($id){
    $data=App\Status::where('id',$id)->first();
    $text='Target';
    if($id==1){
        $sts=$data['name'].' '.$text;
    }else{
        $sts=$data['name'];
    }
    
    

    return $sts;
}

function cek_akumulasi($id){
    $data=App\Akumulasi::where('id',$id)->first();

    return $data['name'];
}

function capaian_all(){
    $data=App\Capaian::all();

    return $data;
}

function kategori(){
    $data=App\Kategori::all();

    return $data;
}
function akumulasi_all(){
    $data=App\Akumulasi::all();

    return $data;
}

function akumulasi($id){
    $data=App\Akumulasi::where('id',$id)->first();

    return $data['name'];
}
function rumus_akumulasi($id,$tahun){
    $net=App\Kpi::where('kode_kpi',$id)->where('tahun',$tahun)->first();

    return $net['rumus_akumulasi'];
}

function target($id,$bul){
    $net=App\Target::where('deployment_id',$id)->where('bulan',$bul)->first();

    return $net;
}
function get_target($id){
    $net=App\Target::where('deployment_id',$id)->orderBy('bulan','Asc')->get();

    return $net;
}
function rumus_capaian($id,$tahun){
    $net=App\Kpi::where('kode_kpi',$id)->where('tahun',$tahun)->first();

    return $net['rumus_capaian'];
}

function max_nilai_tahunan($tahun){
    $parameter=App\Parameter::where('tahun',$tahun)->first();
    return $parameter['nilai'];
}
function hitung_capaian($id,$target,$realisasi,$tahun){
    $deploy=App\Deployment::where('id',$id)->first();
    $capaian=$deploy['rumus_capaian'];
    $parameter=App\Parameter::where('tahun',$tahun)->first();
    if($capaian==3){
        if(is_null($target) || $target==0){
            $cap=100;
        }else{
            if($realisasi==0 || $realisasi==''){
                $cap=0;
            }else{
                $tanggal1 = date_create(date('Y-m-d h:i:s',strtotime($realisasi)));
                $tanggal2 = date_create(date('Y-m-d h:i:s',strtotime($target)));
                $perbedaan = $tanggal1->diff($tanggal2);

                // if($target>=$realisasi){
       
                //     $cap=(1+(-$perbedaan->days/30))*100;
                // }else{
                //     $cap=(1+(-$perbedaan->days/30))*100;
                // }

                $cap=(1+($perbedaan->days/30))*100;
                
            }
            
        }
        
        if($cap>$parameter['nilai']){
            $nicap=$parameter['nilai'];
        }else{
            $nicap=$cap;
        }

        $nil= round($nicap);

    }
    
    if($capaian==4){
        if($target==0){
            $cap=100;
        }else{
            $expld=explode("-",$target);
            if($expld[0]>$realisasi){
                $cap=(1-(($expld[0]-$realisasi)/$expld[0]))*100;
            }else{
                $cap=(1-(($realisasi-$expld[1])/$expld[1]))*100;
            }
        }
        
        if($cap>$parameter['nilai']){
            $nicap=$parameter['nilai'];
        }else{
            $nicap=$cap;
        }

        $nil= round($nicap);

    }
    
    if($capaian==1){
        if($target==0){
            $cap=100;
        }else{
            if($target<0){
                if($realisasi==0){
                    $cap=0;
                }else{
                     $cap=(1+(($target)-($realisasi))/($target))*100;
                }
            }else{
                if($realisasi==0){
                    $cap=0;
                }else{
                     $cap=(1-((($target)-($realisasi))/($target)))*100;
                }
            }
            // if($realisasi==0){
            //     $cap=0;
            // }else{
            //      $cap=(1-((($target)-($realisasi))/($target)))*100;
            // }
            
        }
        
        if($cap>$parameter['nilai']){
            $nicap=$parameter['nilai'];
        }else{
            $nicap=$cap;
        }
        $nil= round($nicap);
    }

    if($capaian==2){
        if($target==0){
            $cap=100;
        }else{
            if($realisasi==0){
                $cap=0;
            }else{
                 $cap=(1+(($target)-($realisasi))/($target))*100;
            }
        }
        
        if($cap>$parameter['nilai']){
            $nicap=$parameter['nilai'];
        }else{
            $nicap=$cap;
        }
        $nil= round($nicap);
    }
    
    if($nil<0){
        $nils=0;
    }else{
        $nils=$nil;
    }
    return $nils;
    
}

function nilai_max($nil,$tahun){
    $param=App\Parameter::where('tahun',$tahun)->first();
    if($nil>$param['nilai']){
        $tot=$param['nilai'];
    }else{
        $tot=substr($nil,0,6);
    }
    return $tot;
}
function total_capaian($kode,$tahun,$bulan){
    $total=0;
    $data  = array_column(
        App\Deployment::where('kode_unit',$kode)->where('tahun',$tahun)->where('status_id', 4)
        ->get()
        ->toArray(),'id'
     );
    
    $detail=App\Target::whereIn('deployment_id',$data)->where('bulan',$bulan)->get();
    foreach($detail as $tar){
        // $total+=hitung_capaian($data['rumus_capaian'],$tar['target'],$tar['realisasi'],$tahun)*cek_bobot($kode,$data['kode_kpi'],$tahun,$bulan);
        $total+=hitung_capaian($tar['deployment_id'],$tar['target'],$tar['realisasi'],$tahun)*cek_bobot($kode,$tar['deployment_id'],$tahun,$bulan);
        // $total+=1;
    }
    
    $hsl=$total/100;
    // $hsl=$total;
    return $hsl;
}
function total_score($kode,$tahun){
    $total=0;
    
     
    $detail=App\Deployment::where('kode_unit',$kode)->where('tahun',$tahun)->where('status_id', 4)->get();
    foreach($detail as $tar){
        // $total+=hitung_capaian($data['rumus_capaian'],$tar['target'],$tar['realisasi'],$tahun)*cek_bobot($kode,$data['kode_kpi'],$tahun,$bulan);
        $total+=score($tar['id'],akumulasi_capaian($tar['id'],akumulasi_target($tar['id']),akumulasi_realisasi($tar['id'])));
        // $total+=1;
    }
    
    $hsl=$total;
    // $hsl=$total;
    return $hsl;
}

function total_capaian_mandatori($tahun,$bulan){
    $total=0;
    foreach(deployment_realisasi_atasan_mandatori($tahun) as $no=>$data){
        $detail=App\Target::where('deployment_id',$data['id'])->where('bulan',$bulan)->get();
        foreach($detail as $tar){
           $total+=hitung_capaian($data['rumus_capaian'],$tar['target'],$tar['realisasi'],$tahun)*($data['bobot_tahunan']/100);
        }
    }
     
    return $total;
}



function total_bobot($kode,$tahun,$bulan){
    $data=App\Masterbobot::where('kode_unit',$kode)->where('tahun',$tahun)->where('bulan',$bulan)->sum('bobot');
    return $data;
}

function get_detail_bobot($kode,$tahun,$kpi){
    $data=App\Masterbobot::where('kode_unit',$kode)->where('tahun',$tahun)->where('kode_kpi',$kpi)->orderBy('bulan','Asc')->get();
    return $data;
}


function total_bobot_mandatori($tahun){
    $total=0;
    foreach(deployment_realisasi_atasan_mandatori($tahun) as $no=>$data){
       
           $total+=$data['bobot_tahunan'];
       
    }
     
    return $total;
}
function bln($id){
    if($id>9){
        $data=$id;
    }else{
        $data='0'.$id;
    }

    return $data;
}

function potongan($tgl,$tahun,$bulan,$cap){


    if($bulan==12){
        $bul='1';
        $thn=$tahun+1;
    }else{
        $bul=$bulan+1;
        $thn=$tahun;
    }

    $tg=explode('-',$tgl);
    $awal  = $tgl;
    $akhir = $thn.'-'.bln($bul).'-'.tgl_validasi($tahun); 

    if($tahun==2020){
        if($bulan>7){
            if($awal>$akhir){
                $tanggal1 = date_create(date('Y-m-d h:i:s',strtotime($awal)));
                $tanggal2 = date_create(date('Y-m-d h:i:s',strtotime($akhir)));
                $perbedaan = $tanggal1->diff($tanggal2);
                $sels = $perbedaan->days;
                if($sels>20){
                    $data=20;
                }else{
                    $data=$sels;
                }
                
                
            }else{
                $data = '0';
            }
        }else{
            $data = 0;
        }
        
    }else{
        
        if($awal>$akhir){
            $tanggal1 = date_create(date('Y-m-d h:i:s',strtotime($awal)));
            $tanggal2 = date_create(date('Y-m-d h:i:s',strtotime($akhir)));
            $perbedaan = $tanggal1->diff($tanggal2);
            $sels = $perbedaan->days;
            if($sels>20){
                $data=20;
            }else{
                $data=$sels;
            }
            
            
        }else{
            $data = '0';
        }
        
    }
    if($data>20){
        $capaian=($cap*10)/100;
    }else{
        $capaian=$cap;
    }
    
    $potong=substr(((0.5*$data)*$capaian)/100,0,4);
    
    
    return $potong;
}

function pilar($kode,$tahun){
    $data=App\Deployment::select('pilar')->where('kode_unit',$kode)->where('tahun',$tahun)->groupBy('pilar')->orderBy('pilar','Asc')->get();
    return $data;
}

function akumulasi_target($id){
    $data=App\Deployment::where('id',$id)->first();
    $detail=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->get();
    $jumlah=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->count();
    $parameter=App\Parameter::where('tahun',$data['tahun'])->first();

    if($data['rumus_capaian']==3){
        $total=0;
    }else{
        if($data['rumus_akumulasi']==1){
            
            $sumx  =App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->sum('target');
            $total=$sumx;
        } 

        if($data['rumus_akumulasi']==2){
            $cek=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->count();
            if($cek>0){
                $sumx  =App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->sum('target');
                $total=$sumx/$cek;
            }else{
                $total=0;
            }
        }

        if($data['rumus_akumulasi']==3){
            $cek=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->count();
            

            if($cek>0){
                $cekdata=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->orderBy('id')->max('id');
                $datar  =App\Target::where('id',$cekdata)->first();
                $total=$datar['target'];
            }else{
                $total=0;
            }
           
        } 
    
    }
    
    
    return nilai_normal($total);
}

function akumulasi_realisasi($id){
    $data=App\Deployment::where('id',$id)->first();
    $detail=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->get();
    $jumlah=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->count();

    if($data['rumus_capaian']==3){
        $total=0;
    }else{
        if($data['rumus_akumulasi']==1){
            
            $total=0;
            foreach($detail as $tar){
                $total+=$tar['realisasi'];
            }
        } 

        if($data['rumus_akumulasi']==2){
            $datar  =App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->count();
            if($datar>0){
                $sumx  =App\Target::where('deployment_id',$id)->sum('realisasi');
                $total=$sumx/$datar;
            }else{
                $total='0';
            }
        }

        if($data['rumus_akumulasi']==3){
            $cek=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->count();
            if($cek>0){
                $cekdata=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->orderBy('id')->max('id');
                $datar  =App\Target::where('id',$cekdata)->first();
                $total=$datar['realisasi'];
            }else{
                $total=0;
            }
        } 
    
    }
    
     
    $hasilnyaa=number_format($total,2,'.','');
    return nilai_normal($total);
}

function akumulasi_capaian($id,$target=null,$realisasi=null){
    $data=App\Deployment::where('id',$id)->first();
    $akumulasi=$data['rumus_akumulasi'];
    $capaian=$data['rumus_capaian'];
    if($capaian==3){
        if(is_null($target) || $target==0){
            $cap=100;
        }else{
            if($realisasi==0 || $realisasi==''){
                $cap=0;
            }else{
                $tanggal1 = date_create(date('Y-m-d h:i:s',strtotime($realisasi)));
                $tanggal2 = date_create(date('Y-m-d h:i:s',strtotime($target)));
                $perbedaan = $tanggal1->diff($tanggal2);

                // if($target>=$realisasi){
       
                //     $cap=(1+(-$perbedaan->days/30))*100;
                // }else{
                //     $cap=(1+(-$perbedaan->days/30))*100;
                // }

                $cap=(1+($perbedaan->days/30))*100;
                
            }
            
        }
        
        if($cap>max_nilai_tahunan($data['tahun'])){
            $nicap=max_nilai_tahunan($data['tahun']);
        }else{
            $nicap=$cap;
        }

        $nil= round($nicap);

    }
    
    if($capaian==4){
        if($target==0){
            $cap=100;
        }else{
            $expld=explode("-",$target);
            if($expld[0]>$realisasi){
                $cap=(1-((($expld[0])-$realisasi)/($expld[0])))*100;
            }else{
                $cap=(1-((($realisasi)-($expld[1]))/($expld[1])))*100;
            }
        }
        
        if($cap>max_nilai_tahunan($data['tahun'])){
            $nicap=max_nilai_tahunan($data['tahun']);
        }else{
            $nicap=$cap;
        }

        $nil= round($nicap);

    }
    
    if($capaian==1){
        if($target==0){
            $cap=100;
        }else{
            if($realisasi==0){
                $cap=0;
            }else{
                if($target<0 && $realisasi>0){
                    $cap=1+(((($target)-($realisasi))/($target))*100);
                }else{
                    $cap=(1-((($target)-($realisasi))/($target)))*100;
                }
                    
                
            }
        }
        
        if($cap>max_nilai_tahunan($data['tahun'])){
            $nicap=max_nilai_tahunan($data['tahun']);
        }else{
            $nicap=$cap;
        }
        $nil= $nicap;
    }

    if($capaian==2){
        if($target==0){
            $cap=100;
        }else{
            if($realisasi==0){
                $cap=0;
            }else{
                 $cap=(1+((($target)-($realisasi))/($target)))*100;
            }
        }
        
        if($cap>max_nilai_tahunan($data['tahun'])){
            $nicap=max_nilai_tahunan($data['tahun']);
        }else{
            $nicap=$cap;
        }
        $nil= round($nicap);
    }
    
    if($nil>0){
        $nilakhir=$nil;
    }else{
        $nilakhir=0;
    }

    return nilai_normal($nilakhir);
}

function nilai_normal($nilai){
    $sisa=explode('.',$nilai);
    $karak=strlen($sisa[1]);
    if($karak==0){
        $hasilnyaa=$nilai;
        
    }else{
        if($karak==1){
            $hasilnyaa=$nilai;
        }
        if($karak==2){
            $hasilnyaa=number_format($nilai,2,'.','');
        }
        if($karak>2){
            $hasilnyaa=number_format($nilai,3,'.','');
        }
        
    }
    return $hasilnyaa;
}

function score($id,$capaian){
    $data=App\Deployment::where('id',$id)->first();
    $detail=App\Target::where('deployment_id',$id)->where('realisasi','!=',0)->orderBy('bulan','desc')->max('bulan');
    $bot=App\Masterbobot::where('kode_kpi',$data['kode_kpi'])->where('kode_unit',$data['kode_unit'])->where('tahun',$data['tahun'])->where('bulan',12)->first();
    $total=$capaian*($bot['bobot']/100);

    return round($total,2);
}

function donut($bln,$tahun){
    $bulan=0;
    foreach(unit() as $o){
        $bulan+=array_kode($o['kode'],$tahun,$bln);
    }

    $data=round($bulan*(100/jumlah_unit()));

    return $data;
}
?>
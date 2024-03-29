<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deployment;
use App\Target;
use Session;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class RealisasiController extends Controller
{
    
    public function index(request $request){
        error_reporting(0);
        
        $kode=$request->kode;
        $tahun=$request->tahun;
        if(Auth::user()['role_id']==2){
            $judul='Realisasi';
            return view('realisasi.index',compact('judul','kode','tahun'));
        }

        if(Auth::user()['role_id']==1){
            $judul='View Realisasi';
            return view('realisasi.index_validasi_admin',compact('judul','kode','tahun'));
        }

        if(Auth::user()['role_id']==3){
            $judul='Validasi Realisasi';
            return view('realisasi.index_validasi',compact('judul','kode','tahun'));
        }
        
    }

    public function laporan(request $request){
        $judul='Laporan Capaian';
        $kode=$request->kode;
        $tahun=$request->tahun;
        
        return view('realisasi.laporan',compact('judul','kode','tahun'));
    }
    public function getdata(request $request){
        
            $data=Deployment::where('tahun',$request->tahun)->where('status_id',4)->get();
            if($request->act==1){
                foreach($data as $o){
                    $target=Target::where('deployment_id',$o['id'])->get();
                    foreach($target as $tar){
                        $save=Target::where('id',$tar['id'])->update([
                            'capaian'=>hitung_capaian($o['id'],$tar['target'],$tar['realisasi'],$request->tahun),
                        ]);
                        
                    }
                    
                }
            }
            if($request->act==2){
                foreach($data as $o){
                    $save=Deployment::where('id',$o['id'])->update([
                        'komulatif_target'=>akumulasi_target($o['id']),
                        'komulatif_realisasi'=>akumulasi_realisasi($o['id']),
                        'komulatif_capaian'=>akumulasi_capaian($o['id'],akumulasi_target($o['id']),akumulasi_realisasi($o['id'])),
                    ]);
                    
                }
            }
    }
    public function getdataakumulasi(request $request){
        
            $data=Deployment::where('tahun',$request->tahun)->get();
            foreach($data as $o){
                $save=Deployment::where('id',$o['id'])->update([
                    'komulatif_target'=>akumulasi_target($o['id']),
                    'komulatif_realisasi'=>akumulasi_realisasi($o['id']),
                    'komulatif_capaian'=>akumulasi_capaian($o['id'],akumulasi_target($o['id']),akumulasi_realisasi($o['id'])),
                ]);
                
            }
    }

    public function laporan_subdit(request $request){
        error_reporting(0);
        $judul='Laporan Capaian';
        if($request->kode==''){
            $kode='50000958';
            $tahun=date('Y');
        }else{
            $kode=$request->kode;
            $tahun=$request->tahun;
        }
        // dd(array_unit_atasan_subdit($kode));
        
        
        return view('realisasi.laporan_subdit',compact('judul','kode','tahun'));
        
    }
    public function laporan_subdit_new(request $request){
        error_reporting(0);
        $judul='Laporan Capaian';
        if($request->kode==''){
            $kode=111111;
            $tahun=date('Y');
        }else{
            $kode=$request->kode;
            $tahun=$request->tahun;
        }
        
        
        return view('realisasi.laporan_subdit',compact('judul','kode','tahun'));
    }
    public function laporan_tingkatan(request $request,$id){
        $judul='Laporan Capaian';
        $kode=$request->kode;
        $tahun=$request->tahun;
        $id=$id;
        return view('realisasi.laporan-tingkatan',compact('judul','kode','tahun','id'));
    }

    public function laporan_mandatori(request $request){
        $judul='Laporan Capaian';
        if($request->tahun==''){
            $kode=$request->kode;
            $tahun=date('Y');
        }else{
            $kode=$request->kode;
            $tahun=$request->tahun;
        }
        
        return view('realisasi.laporan_mandatori',compact('judul','kode','tahun'));
    }
    public function index_mandatori(request $request){
        error_reporting(0);
        $judul='Deployment Mandatori';
        $tahun=$request->tahun;
        return view('realisasi.index_mandatori',compact('judul','tahun'));
    }

    public function input_realisasi($id){
        $judul='Input realisasi';
        $data=Deployment::where('id',$id)->first();
        $kode=$data['kode_unit'];
        $tahun=$data['tahun'];

        if(Auth::user()['role_id']==2){
            return view('realisasi.input_realisasi',compact('judul','data','id','kode','tahun'));
        }

        if(Auth::user()['role_id']==1){
            return view('realisasi.view_input_realisasi',compact('judul','data','id','kode','tahun'));
        }

        if(Auth::user()['role_id']==3){
            return view('realisasi.view_input_realisasi',compact('judul','data','id','kode','tahun'));
        }
        
        
    }
    public function input_realisasi_mandatori($id){
        $judul='Input Realisasi Mandatori';
        $data=Deployment::where('id',$id)->first();
        $tahun=$data['tahun'];

         if(Auth::user()['role_id']==1){
            return view('realisasi.input_realisasi_mandatori',compact('judul','data','id','tahun'));
        }

        if(Auth::user()['role_id']==3){
            return view('realisasi.view_input_realisasi',compact('judul','data','id','tahun'));
        }
        
    }

    

    public function simpan(request $request,$id){
        if (trim($request->kpi) == '') {$error[] = '- Isi Nama KPI';}
        if (trim($request->deskripsi) == '') {$error[] = '- Isi Deskripsi KPI';}
        if (trim($request->satuan) == '') {$error[] = '- Isi Satuan KPI';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data                       =   Kpi::find($id);
            $data->kpi                  =   $request->kpi;
            $data->satuan               =   $request->satuan;
            $data->deskripsi            =   $request->deskripsi;
            $data->save();

            
            echo'ok';
        }
    }

    public function simpan_target(request $request,$id){
        error_reporting(0);
        $data                       =   Deployment::find($id);
        $data->status_id            =   2;
        $data->save();

        $count=count($request->id);
        //echo $count;
        if($data){
            for($x=0;$x<12;$x++){
                if($request->id[$x]==''){
                    if($request->target[$x]==''){
                        $detail     = new Target;
                        $detail->deployment_id = $id;
                        $detail->target = 0;
                        $detail->bulan = $request->bulan[$x];
                        $detail->save();
                    }else{
                        $detail     = new Target;
                        $detail->deployment_id = $id;
                        $detail->target = $request->target[$x];
                        $detail->bulan = $request->bulan[$x];
                        $detail->save();
                    }
                }else{
                        $detail     = Target::find($request->id[$x]);
                        $detail->target = $request->target[$x];
                        $detail->save();
                }
                    
            }

            echo'ok';
        }

            
         
    }

    public function validasi_atasan_target($id){
        $data           = Deployment::find($id);
        $data->status_id= 3;
        $data->tgl_validasi_atasan= date('Y-m-d');
        $data->save();
    }

    public function validasi_bulanan($kode,$bulan,$tahun){
        $deploy=Deployment::where('tahun',$tahun)->where('kode_unit',$kode)->where('sts',0)->get();

        foreach($deploy as $dep){
            // $data           = Target::where('deployment_id',$dep['id'])->where('bulan',$bulan)->first();
            // $data->status_realisasi= 2;
            // $data->tgl_validasi_atasan= date('Y-m-d');
            // $data->save();
            $data= Target::where('deployment_id',$dep['id'])->where('bulan',$bulan)->update(
                ['tgl_validasi_atasan'=>date('Y-m-d'),'status_realisasi'=>2]
            );
        }
        
    }

    public function unvalidasi_bulanan($kode,$bulan,$tahun){
        $deploy=Deployment::where('tahun',$tahun)->where('kode_unit',$kode)->where('sts',0)->get();

        foreach($deploy as $dep){
            // $data           = Target::where('deployment_id',$dep['id'])->where('bulan',$bulan)->first();
            // $data->status_realisasi= 2;
            // $data->tgl_validasi_atasan= date('Y-m-d');
            // $data->save();
            $data= Target::where('deployment_id',$dep['id'])->where('bulan',$bulan)->update(
                ['tgl_validasi_atasan'=>null,'status_realisasi'=>1]
            );
        }
        
    }

    public function validasi_atasan_realisasi($id){

    }

    public function validasi_admin_target($id){
        $data           = Deployment::find($id);
        $data->status_id= 4;
        $data->status_realisasi= 1;
        $data->tgl_validasi_admin= date('Y-m-d');
        $data->save();
    }

    public function validasi_admin_realisasi($id){

    }

    public function perhitungan(request $request){
        $data=Target::where('id',$request->id)->first();
            echo hitung_capaian($data['deployment_id'],$request->target,$request->realisasi,$request->tahun);
            // echo $request->tahun;
    }

    public function simpan_realisasi(request $request,$id){
        if (trim($request->realisasi) == '') {$error[] = '- Isi Nilai Realisasi';}
        if (trim($request->file) == '') {$error[] = '- Upload file';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->capaian>95){
                $cek=explode('/',$_FILES['file']['type']);
                $file_tmp=$_FILES['file']['tmp_name'];
                $file=explode('.',$_FILES['file']['name']);
                $filename=md5(date('Ymdhis')).'.'.$cek[1];
                $lokasi='_file_upload/';
                
                if($_FILES['file']['type']=='application/pdf'){
                    if($_FILES['file']['size']<=600000){
                        if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                            $data           = Target::find($id);
                            $data->realisasi= $request->realisasi;
                            $data->status_realisasi=1;
                            $data->file= $filename;
                            $data->save();

                            if($data){
                                echo'ok';
                            }
                            
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Maximal size file 500kb</p>'; 
                    }
                }else{
                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus Pdf</p>';
                }
            }else{
               
                if (trim($request->masalah) == '') {$error[] = '- Isi masalah ';}
                if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                else{
                    //cekk
                    $cek=explode('/',$_FILES['file']['type']);
                    $file_tmp=$_FILES['file']['tmp_name'];
                    $file=explode('.',$_FILES['file']['name']);
                    $filename=md5(date('Ymdhis')).'.'.$cek[1];
                    $lokasi='_file_upload/';
                    
                    if($_FILES['file']['type']=='application/pdf'){
                        if($_FILES['file']['size']<=600000){
                            if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                                $data           = Target::find($id);
                                $data->realisasi= $request->realisasi;
                                $data->masalah= $request->masalah;
                                $data->rencana= $request->rencana;
                                $data->status_realisasi=1;
                                $data->file= $filename;
                                $data->save();

                                if($data){
                                    echo'ok';
                                }
                                
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Maximal size file 500kb</p>'; 
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus Pdf</p>';
                    }

                    // echo $filename;
                }

            }
        }
    }

    public function simpan_realisasi_mandatori(request $request,$id){
        if (trim($request->realisasi) == '') {$error[] = '- Isi Nilai Realisasi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            $data           = Target::find($id);
            $data->realisasi= $request->realisasi;
            $data->save();

            if($data){
                echo'ok';
            }
                    
            
        }
    }

    public function pdf(request $request){
        error_reporting(0);
        $kode=$request->kode;
        $tahun=$request->tahun;
        
        // return view('pdf.laporan_capaian', compact('kode','tahun'));
        $pdf = PDF::loadView('pdf.laporan_capaian', compact('kode','tahun'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function pdf_mandatori(request $request){
        error_reporting(0);
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        
        

        
        $pdf = PDF::loadView('pdf.laporan_capaian_mandatori', compact('tahun'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function excel(request $request){
        error_reporting(0);
        $kode=$request->kode;
        $tahun=$request->tahun;
        

        return view('excel.laporan_capaian', compact('kode','tahun'));
    }
    public function excel_subdit(request $request){
        error_reporting(0);
        ini_set('max_execution_time', 300000);
        $kode=$request->kode;
        $tahun=$request->tahun;
        

        return view('excel.laporan_capaian_subdit', compact('kode','tahun'));
    }

    public function excel_mandatori(request $request){
        error_reporting(0);
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        

        return view('excel.laporan_capaian_mandatori', compact('tahun'));
    }

}

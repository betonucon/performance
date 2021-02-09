<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Deployment;
use App\Target;
use App\Masterbobot;
use Session;

use App\Imports\TargetImport;
use App\Imports\DeploymentImport;
use App\Imports\BobotImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class DeploymentController extends Controller
{
    public function index(){
        $judul='Deployment';
        return view('deployment.index',compact('judul'));
    }
    public function index_mandatori(){
        $judul='Deployment Mandatori';
        return view('deployment.index_mandatori',compact('judul'));
    }
    public function index_non(){
        $judul='Deployment Non Mandatori';
        return view('deployment.index_non',compact('judul'));
    }
    public function index_bobot(request $request){
        $judul='Master Bobot';
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        return view('bobot.index',compact('judul','tahun'));
    }
    public function index_validasi(request $request){
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        $judul='Tanggal Validasi';
        return view('deployment.index_validasi',compact('judul','tahun'));
    }
    public function edit($id){
        $judul='Deployment';
        $data=Deployment::where('id',$id)->first();
        return view('deployment.edit',compact('judul','data','id'));
    }
    public function edit_validasi(request $request){
        $judul='Ubah Tanggal Validasi';
        $kode=$request->kode;
        $tahun=$request->tahun;
        return view('deployment.edit_validasi',compact('judul','kode','tahun'));
    }
    public function edit_mandatori($id){
        $judul='Deployment';
        $data=Deployment::where('id',$id)->first();
        return view('deployment.edit_mandatori',compact('judul','data','id'));
    }

    public function import_data(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new DeploymentImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','Data Berhasil Diimport!');
    }

    public function import_data_mandatori(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new TargetImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','Data Berhasil Diimport!');
    }

    public function simpan(request $request,$id){
        if (trim($request->target_tahunan) == '') {$error[] = '- Isi Target Tahunan';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data                       =   Deployment::find($id);
            $data->target_tahunan       =   $request->target_tahunan;
            $data->rumus_akumulasi      =   $request->rumus_akumulasi;
            $data->rumus_capaian        =   $request->rumus_capaian;
            $data->sts        =   $request->sts;
            $data->save();

            
            echo'ok';
        }
    }

    public function view_api_bobot(request $request){
        error_reporting(0);
        if($request->kode==''){
            $data=Deployment::where('tahun',$request->tahun)->orderBy('id','Desc')->paginate(200);
        }else{
            $data=Deployment::where('tahun',$request->tahun)->where('kode_unit',$request->kode)->orderBy('id','Desc')->get();
        }
       
        echo'
            <style>
                th{
                    text-align:center;
                    background:aqua;
                    font-size:14px;
                }
                td{
                    font-size:12px;
                }
            </style>
            <table width="100%" >
                <tr>
                    <th>NO</th>
                    <th>Kode KPI</th>
                    <th>Unit Kerja</th>';
                    for($b=1;$b<13;$b++){
                        echo' <th>'.substr(bulan(bulan_db($b)),0,3).'</th>';
                    }
                echo'
                </tr>';
                foreach($data as $no=>$o){
                    echo'
                        <tr>
                            <td>'.($no+1).'</td>
                            <td>'.$o['kode_kpi'].'</td>
                            <td>'.$o['kode_unit'].' '.cek_unit($o['kode_unit'])['nama'].'</td>';
                            for($b=1;$b<13;$b++){
                                echo' <td>'.cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],$b).'</td>';
                            }
                            echo'
                        </tr>

                    ';

                }
            echo'</table>
        ';
    }
    public function api_bobot(request $request){
        error_reporting(0);
        $data=Deployment::where('tahun',$request->tahun)->orderBy('id','Desc')->get();
        
        foreach($data as $o){
        
            $show[]=array(
                "id" =>$o['id'],
                "kode_kpi" =>$o['kode_kpi'],
                "kode_unit" =>$o['kode_unit'],
                "name_unit" =>cek_unit($o['kode_unit'])['nama'],
                "Jan" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],1),
                "Feb" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],2),
                "Mar" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],3),
                "Apr" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],4),
                "Mei" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],5),
                "Jun" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],6),
                "Jul" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],7),
                "Ags" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],8),
                "Sep" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],9),
                "Okt" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],10),
                "Nov" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],11),
                "Des" =>cek_bobot($o['kode_unit'],$o['kode_kpi'],$o['tahun'],12)
            );
        }
        
        echo json_encode($show);
        
    }

    public function simpan_validasi(request $request){
        error_reporting(0);
        $jum=count($request->bulan);
        
        
        
            for($x=0;$x<$jum;$x++){
                if($request->tanggal[$x]==0 || $request->tanggal[$x]==''){
    
                }else{
                    Target::whereIn('deployment_id',array_deployment($request->kode_unit,$request->tahun))->where('bulan',$request->bulan[$x])->update(
                    [
                        'tgl_validasi_atasan' =>$request->tanggal[$x]
                    ]);



                }
            }
        
                    
            
        
        echo 'ok';
    }
    public function api_validasi($tahun){
        error_reporting(0);
        $data=Deployment::select('kode_unit','tahun')->where('tahun',$tahun)->groupBy('kode_unit')->groupBy('tahun')->get();
        
        foreach($data as $o){
        
            $show[]=array(
                "kode_unit" =>$o['kode_unit'],
                "tahun" =>$o['tahun'],
                "name_unit" =>cek_unit($o['kode_unit'])['nama'],
                "Jan" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],1)),
                "Feb" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],2)),
                "Mar" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],3)),
                "Apr" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],4)),
                "Mei" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],5)),
                "Jun" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],6)),
                "Jul" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],7)),
                "Ags" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],8)),
                "Sep" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],9)),
                "Okt" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],10)),
                "Nov" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],11)),
                "Des" =>tgl(tgl_validasi_atasan($o['kode_unit'],$o['tahun'],12))
            );
        }
        
        echo json_encode($show);
        
    }

    public function import_data_bobot(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new BobotImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','Data Bobot Sukses!');
    }
}

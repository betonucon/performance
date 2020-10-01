<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Deployment;
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
    public function index_bobot(){
        $judul='Master Bobot';
        return view('bobot.index',compact('judul'));
    }
    public function edit($id){
        $judul='Deployment';
        $data=Deployment::where('id',$id)->first();
        return view('deployment.edit',compact('judul','data','id'));
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
        if (trim($request->bobot_tahunan) == '') {$error[] = '- Isi Bobot Tahunan';}
        if (trim($request->target_tahunan) == '') {$error[] = '- Isi Target Tahunan';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data                       =   Deployment::find($id);
            $data->bobot_tahunan        =   $request->bobot_tahunan;
            $data->target_tahunan       =   $request->target_tahunan;
            $data->rumus_akumulasi      =   $request->rumus_akumulasi;
            $data->rumus_capaian        =   $request->rumus_capaian;
            $data->sts        =   $request->sts;
            $data->save();

            
            echo'ok';
        }
    }

    public function api_bobot(){
        
        $data=Deployment::orderBy('id','Desc')->get();
        
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Deployment;
use Session;

use App\Imports\DeploymentImport;
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

    public function edit($id){
        $judul='Deployment';
        $data=Deployment::where('id',$id)->first();
        return view('deployment.edit',compact('judul','data','id'));
    }

    public function import_data(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new DeploymentImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','Data Siswa Berhasil Diimport!');
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
}

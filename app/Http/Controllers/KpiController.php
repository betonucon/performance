<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kpi;
use Session;

use App\Imports\KpiImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
class KpiController extends Controller
{
    public function index(){
        $judul='KPI';
        return view('kpi.index',compact('judul'));
    }

    public function edit($id){
        $judul='Ubah KPI';
        $data=Kpi::where('id',$id)->first();
        return view('kpi.edit',compact('judul','data','id'));
    }

    public function import_data(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new KpiImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','Data Kpi Sukses!');
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
}

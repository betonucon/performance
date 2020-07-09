<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tanggalvalidasi;
use Session;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function index(){
        return view('pengaturan');
    }

    public function simpan_tanggal_validasi(request $request){
        if (trim($request->tahun) == '') {$error[] = '- Pilih Tahun';}
        if (trim($request->tanggal) == '') {$error[] = '- Pilih Tanggal';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Tanggalvalidasi::where('tahun',$request->tahun)->count();
            if($cek>0){
                echo'<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />Tahun ini sudah ada</p>';
            }else{
                $data       = new Tanggalvalidasi;
                $data->tahun = $request->tahun;
                $data->tanggal = $request->tanggal;
                $data->save();

                echo'ok';
            }
            
        }
    }
    public function edit_simpan_tanggal_validasi(request $request,$id){
        if (trim($request->tanggal) == '') {$error[] = '- Pilih Tanggal';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data       = Tanggalvalidasi::find($id);
            $data->tanggal = $request->tanggal;
            $data->save();

            echo'ok';
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Unit;
use App\User;
use App\Hasrole;
use Session;

use App\Imports\UnitkerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
class UnitController extends Controller
{
    public function index(){
        $judul='Unit Kerja';
        return view('unit.index',compact('judul'));
    }
    public function index_tingkatan(){
        $judul='Unit Kerja Bertingkat';
        return view('unit.index_tingkatan',compact('judul'));
    }

    public function edit($id){
        $judul='Unit Kerja';
        $data=Unit::where('id',$id)->first();
        return view('unit.edit',compact('judul','data','id'));
    }

    public function import_data(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new UnitkerjaImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','Data Berhasil Diimport!');
    }

    public function cek_nik($act,$id){
        $json = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$id);
        $item = json_decode($json,true);
        $unit=$item;
        if($act=='pic'){
            $cek=Unit::where('nik_atasan',$id)->count();
            if($cek>0){
                echo 'terdaftar';
            }else{
                echo $item['name'];
            }
            
        }

        if($act=='atasan'){
            $cek=Unit::where('nik',$id)->count();
            if($cek>0){
                echo 'terdaftar';
            }else{
                echo $item['name'];
            }
            
        }
        
            
    }

    public function simpan(request $request,$id){
        if (trim($request->nik) == '') {$error[] = '- Masukan Nik PIC';}
        if (trim($request->nama_pic) == '') {$error[] = '- Masukan Nama PIC';}
        if (trim($request->nik_atasan) == '') {$error[] = '- Masukan Nik Atasan';}
        if (trim($request->nama_atasan) == '') {$error[] = '- Masukan Nama Atasan';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data            =   Unit::find($id);
            $data->nik       =   $request->nik;
            $data->nik_atasan=   $request->nik_atasan;
            $data->nama_pic  =   $request->nama_pic;
            $data->nama_atasan  =   $request->nama_atasan;
            $data->save();

            $cek=User::where('nik',$request->nik)->count();
            if($cek>0){

            }else{
                $user = new User;
                $user->name = $request->nama_pic;
                $user->nik = $request->nik;
                $user->password = Hash::make($request->nik);
                $user->role_id = 2;
                $user->save();

            }

            $cekk=User::where('nik',$request->nik_atasan)->count();
            if($cekk>0){

            }else{
                $user = new User;
                $user->name = $request->nama_atasan;
                $user->nik = $request->nik_atasan;
                $user->password = Hash::make($request->nik_atasan);
                $user->role_id = 3;
                $user->save();

            }

            echo'ok';
        }
    }

    public function rolee(){
        $role=Hasrole::all();

        foreach($role as $rol){
            $data= User::where('id',$rol['model_id'])->update(['role_id'=>$rol['role_id']]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deployment;
use App\Target;
use Session;

use App\Imports\TargetImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class TargetController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        $judul='Deployment';
        $kode=$request->kode;
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        
        return view('target.index',compact('judul','kode','tahun'));
    }
    public function index_mandatori(request $request){
        error_reporting(0);
        $judul='Deployment Mandatori';
        $kode=$request->kode;
        $tahun=$request->tahun;
        return view('target.index_mandatori',compact('judul','kode','tahun'));
    }

    public function input_target($id){
        $judul='Input Target';
        $data=Deployment::where('id',$id)->first();
        $kode=$data['kode_unit'];
        $tahun=$data['tahun'];

        if(Auth::user()['role_id']==2){
            return view('target.input_target',compact('judul','data','id','kode','tahun'));
        }

        if(Auth::user()['role_id']==1){
            return view('target.view_input_target',compact('judul','data','id','kode','tahun'));
        }

        if(Auth::user()['role_id']==3){
            return view('target.view_input_target',compact('judul','data','id','kode','tahun'));
        }
        
        
    }
    public function input_target_mandatori($id){
        $judul='Input Target Mandatori';
        $data=Deployment::where('id',$id)->first();
        $kode=$data['kode_unit'];
        $tahun=$data['tahun'];

        if(Auth::user()['role_id']==1){
            return view('target.input_target_mandatori',compact('judul','data','id','kode','tahun'));
        }else{
            redirect('/target/');
        }

        
    }

    public function import_data(request $request)
    {
       error_reporting(0);
		// menangkap file excel
        $filess = $request->file('file');
        $nama_file = rand().$filess->getClientOriginalName();
        $filess->move('file_excel',$nama_file);
        Excel::import(new TargetImport, public_path('/file_excel/'.$nama_file));
        Session::flash('sukses','ok');
    }

    

    public function simpan_selesai_target(request $request,$id){
        error_reporting(0);
        $data                       =   Deployment::find($id);
        $data->status_id            =   4;
        $data->save();

        if($data){
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
                        $detail->realisasi = 0;
                        $detail->bulan = $request->bulan[$x];
                        $detail->save();
                    }else{
                        $detail     = new Target;
                        $detail->deployment_id = $id;
                        $detail->target = $request->target[$x];
                        $detail->realisasi = 0;
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

    public function validasi_all($id){
        if(Auth::user()['role_id']==1){
            $data= Deployment::where('tahun',$id)->where('status_id',3)
                    ->update(['status_id'=>4]);
        }
        
        if(Auth::user()['role_id']==3){
            $data= Deployment::where('tahun',$id)->whereIn('kode_unit',array_user())->where('status_id',2)
                    ->update(['status_id'=>3]);
        }
    }

    public function validasi_admin_target($id){
        $data           = Deployment::find($id);
        $data->status_id= 4;
        $data->status_realisasi= 1;
        $data->tgl_validasi_admin= date('Y-m-d');
        $data->save();
    }

    public function unvalidasi_admin_target($id){
        $data           = Deployment::find($id);
        $data->status_id= 2;
        $data->status_realisasi= 0;
        $data->save();
    }

    public function validasi_admin_realisasi($id){

    }
}

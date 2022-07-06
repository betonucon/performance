<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
class GetadataController extends Controller
{
    public function capaian(request $request){
        date_default_timezone_set('Asia/Jakarta');
        $cek = DB::connection('mysql')->table('users')->where('role_id',1)->where('token',$request->token)->count();
        if($cek>0){
            $data=DB::connection('mysql')->table('view_capaian')->where('kode',$request->kode)->where('tahun',$request->tahun)->get();
            return response()->json($data);
        }else{
            echo'Token Not Valid';
        }
        
    }
    public function kpi(request $request){
        date_default_timezone_set('Asia/Jakarta');
        $cek = DB::connection('mysql')->table('users')->where('role_id',1)->where('token',$request->token)->count();
        if($cek>0){
            $data=DB::connection('mysql')->table('view_kpi')->where('tahun',$request->tahun)->get();
            return response()->json($data);
        }else{
            echo'Token Not Valid';
        }
        
    }
    public function unit(request $request){
        date_default_timezone_set('Asia/Jakarta');
        $cek = DB::connection('mysql')->table('users')->where('role_id',1)->where('token',$request->token)->count();
        if($cek>0){
            $data=DB::connection('mysql')->table('view_unit')->get();
            return response()->json($data);
        }else{
            echo'Token Not Valid';
        }
        
    }
}

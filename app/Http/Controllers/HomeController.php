<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {
        if($request->tahun==''){
            $tahun=date('Y');
            $bulan=date('m');
        }else{
            $tahun=$request->tahun;
            $bulan=$request->bulan;
        }
       if(Auth::user()['role_id']==1){
            return view('home',compact('tahun','bulan'));
       }
       if(Auth::user()['role_id']==2){
            return view('home_atasan',compact('tahun','bulan'));
       }
       if(Auth::user()['role_id']==3){
            return view('home_atasan',compact('tahun','bulan'));
       }
        
    }
    public function pdf()
    {
        $data='Hai PDF';
        $pdf = PDF::loadView('pdf', ['data'=>$data]);
        return $pdf->stream();
    }
}

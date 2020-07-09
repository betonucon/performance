<?php

function barcoderider($id,$w,$h){
    $d = new Milon\Barcode\DNS2D();
    $d->setStorPath(__DIR__.'/cache/');
    return $d->getBarcodeHTML($id, 'QRCODE',$w,$h);
}
function barcode($id){
    $d = new Milon\Barcode\DNS2D();
    $d->setStorPath(__DIR__.'/cache/');
    return $d->getBarcodePNGPath($id, 'PDF417');
}

function unit(){
    $data=App\Unit::whereIn('unit_id',[3,5,1])->orderBy('nama','Asc')->get();

    return $data;
}
function unit_subdit(){
    $data=App\Unit::where('unit_id',1)->where('nik_atasan',Auth::user()['nik'])->orderBy('nama','Asc')->get();

    return $data;
}
function cek_subdit(){
    $data=App\Unit::where('unit_id',1)->where('nik_atasan',Auth::user()['nik'])->count();

    return $data;
}
function unit_direktorat(){
    $data=App\Unit::where('unit_id',5)->where('nik_atasan',Auth::user()['nik'])->orderBy('nama','Asc')->get();

    return $data;
}
function get_unit_subdit($id){
    $data=App\Unit::where('kode_unit',$id)->orderBy('nama','Asc')->get();

    return $data;
}

function array_subdit(){
    

    $data  = array_column(
        App\Unit::where('unit_id',5)->where('nik_atasan',Auth::user()['nik'])
        ->get()
        ->toArray(),'kode'
     );

    $subdata=App\Unit::where('unit_id',1)->whereIn('kode_unit',$data)->orderBy('nama','Asc')->get();

    return $subdata;
}


function cek_direktorat(){
    $data=App\Unit::where('unit_id',5)->where('nik_atasan',Auth::user()['nik'])->count();

    return $data;
}
function unit_tingkatan(){
    $data=App\Unit::whereIn('unit_id',[3,1])->orderBy('unit_id','Asc')->get();

    return $data;
}

function cek_unit($id){
    $data=App\Unit::where('kode',$id)->first();

    return $data;
}

function unit_user(){
    if(Auth::user()['role_id']==2){
        $data  = array_column(
           App\Unit::where('nik', Auth::user()['nik'])
           ->get()
           ->toArray(),'kode'
        );
     }
     if(Auth::user()['role_id']==3){
        $data  = array_column(
            App\Unit::where('nik_atasan', Auth::user()['nik'])
            ->get()
            ->toArray(),'kode'
         );
     }
     

     return $data;
}

function jumlah_unit(){
    if(Auth::user()['role_id']==1){
        $data=App\Unit::whereIn('unit_id',[3,5,1])->count();
    }
    if(Auth::user()['role_id']==3){
        $data=App\Unit::whereIn('unit_id',[3,5,1])->whereIn('kode',unit_user())->count();
    }
    if(Auth::user()['role_id']==2){
        $data=App\Unit::whereIn('unit_id',[3,5,1])->whereIn('kode',unit_user())->count();
    }
    

    return $data;
}

?>
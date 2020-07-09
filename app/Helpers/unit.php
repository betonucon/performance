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
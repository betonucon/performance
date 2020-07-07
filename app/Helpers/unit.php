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
function jumlah_unit(){
    $data=App\Unit::whereIn('unit_id',[3,5,1])->count();

    return $data;
}
function cek_unit($id){
    $data=App\Unit::where('kode',$id)->first();

    return $data;
}

?>
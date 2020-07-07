<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $table = 'kpis';
    public $timestamps = false;
    protected $fillable = ['kode_kpi','kpi','satuan','rumus_capaian','rumus_akumulasi','deskripsi','keterangan','waktu'];

}

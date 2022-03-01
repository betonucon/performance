<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    protected $table = 'deployment';
    public $timestamps = false;
    protected $fillable = ['kode_unit','kode_kpi','target_tahunan','bobot_tahunan','tahun','rumus_akumulasi','rumus_capaian','id_kpi_unix','kode_unit_tingkat','level','sts','status_id','updated_at','pilar'];
    function pilarnya(){
		return $this->belongsTo('App\Pilar','pilar','kode');
    }
}

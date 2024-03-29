<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit_kerja';
    public $timestamps = false;
    protected $fillable = ['kode_unit'];

    function user(){
		return $this->belongsTo('App\User','nik_atasan','nik');
    }
}

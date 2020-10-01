<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterbobot extends Model
{
    protected $table = 'master_bobot';
    public $timestamps = false;
    protected $fillable = ['kode_kpi','kode_unit','tahun','bulan','bobot'];
}

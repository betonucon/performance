<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    protected $table = 'bobot';
    public $timestamps = false;
    protected $fillable = ['kode_kpi','kode_unit','bulan','bobot','tahun'];
}


<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    protected $table = 'bobot';
    public $timestamps = false;
    protected $fillable = ['kode_unit','kode_kpi','bulan','bobot','tahun'];
}


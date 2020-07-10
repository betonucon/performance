<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'deployment_targets';
    public $timestamps = false;
    protected $fillable = ['deployment_id','bulan','target','realisasi','status_realisasi'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'deployment_targets';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_riwayat';
    
    protected $dates = ['created_at', 'updated_at'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_log';

    protected $dates = ['created_at', 'updated_at'];
}

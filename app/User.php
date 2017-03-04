<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  protected $primaryKey = 'id_user';
  protected $table = 't_akun';

  protected $hidden = [
      'password', 'remember_token',
  ];
}

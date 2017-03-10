<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class AccountController extends Controller
{
  public function show($id){
    $user = User::where('id_user', $id)->first();

    return view('pages.akun.detail')->with('user', $user);
  }
}

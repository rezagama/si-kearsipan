<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\User;
use Redirect;
use Auth;

class LoginController extends Controller
{
    public function index(){
      return view('pages.login');
    }

    public function login(Request $request){
      $nip = $request->input('nip');
      $password = $request->input('password');

      $user = User::where('nip', $nip)->first();
      if($user){
        if(password_verify($password, $user->password)){
          if(Auth::attempt([
            'nip' => $nip, 'password' => $password
          ])){
            return Redirect::route('dashboard.index');
          }
        }else{
          return Redirect::back()->with('error', "Password salah.");
        }
      }else{
        return Redirect::back()->with('error', "Akun tidak ditemukan.");
      }
    }

    public function logout(){
      Auth::logout();
      return Redirect::route('login.index')->with('info', 'Anda telah berhasil keluar dari Sistem Informasi Kearsipan.');
    }
}

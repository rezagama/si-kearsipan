<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\Pengumuman;
use App\User;
use Redirect;
use Auth;
use DB;

class LoginController extends Controller
{
    public function index(){
      $pengumuman = DB::table('t_pengumuman')
                      ->join('t_akun', 't_pengumuman.id_user', '=', 't_akun.id_user')
                      ->select('t_pengumuman.*', 't_akun.nama', 't_akun.id_user')
                      ->get();

      $jumlah_pengumuman = Pengumuman::all()->count();

      return view('pages.login')->with('pengumuman', $pengumuman)
                  ->with('jumlah_pengumuman', $jumlah_pengumuman);
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

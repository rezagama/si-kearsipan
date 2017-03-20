<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pengumuman;
use DB;

class DashboardController extends Controller
{
    public function index(){
      $pengumuman = DB::table('t_pengumuman')
                      ->join('t_akun', 't_pengumuman.id_user', '=', 't_akun.id_user')
                      ->select('t_pengumuman.*', 't_akun.nama', 't_akun.id_user')
                      ->get();

      $jumlah_pengumuman = Pengumuman::all()->count();

      return view('pages.dashboard')->with('pengumuman', $pengumuman)
                  ->with('jumlah_pengumuman', $jumlah_pengumuman);
    }
}

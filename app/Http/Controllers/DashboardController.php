<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pengumuman;
use App\Direktori;
use App\Arsip;
use App\User;
use DB;

class DashboardController extends Controller
{
    public function index(){
      $jumlah_admin = User::where('level', 0)->count();
      $jumlah_staff = User::where('level', 1)->count();
      $jumlah_arsip = Arsip::all()->count();
      $jumlah_direktori = Direktori::all()->count();
      $arsip_retensi = Arsip::orderBy('jadwal_retensi', 'ASC')->take(5)->get();

      $log = DB::table('t_log')
              ->whereNotIn('t_log.tipe', [4])
              ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
              ->orderBy('t_log.created_at', 'DESC')
              ->select('t_log.*', 't_akun.foto')
              ->take(5)->get();

      return view('pages.dashboard')->with('jumlah_admin', $jumlah_admin)
                        ->with('jumlah_staff', $jumlah_staff)
                        ->with('jumlah_arsip', $jumlah_arsip)
                        ->with('jumlah_direktori', $jumlah_direktori)
                        ->with('arsip_retensi', $arsip_retensi)
                        ->with('log', $log);
    }
}

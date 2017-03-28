<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Statistik;
use App\Arsip;
use DB;

class StatistikController extends Controller
{
    public function index(){
      $arsip_aktif = Arsip::where('status', 1)->count();
      $arsip_inaktif = Arsip::where('status', 2)->count();
      $arsip_statis = Arsip::where('status', 3)->count();
      $arsip_musnah = Arsip::where('status', 0)->count();
      $arsip_lain = Arsip::where('status', 4)->count();

      $arsip_akses = DB::table('t_statistik')->join('t_arsip', 't_statistik.id_arsip', '=', 't_arsip.id_arsip')
                              ->orderBy('t_statistik.jumlah_akses', 'DESC')
                              ->take(5)->get();

      $arsip_unduh = DB::table('t_statistik')->join('t_arsip', 't_statistik.id_arsip', '=', 't_arsip.id_arsip')
                              ->orderBy('t_statistik.jumlah_unduh', 'DESC')
                              ->take(5)->get();

      $arsip_cetak = DB::table('t_statistik')->join('t_arsip', 't_statistik.id_arsip', '=', 't_arsip.id_arsip')
                              ->orderBy('t_statistik.jumlah_cetak', 'DESC')
                              ->take(5)->get();

      $arsip_retensi = Arsip::orderBy('jadwal_retensi', 'ASC')->take(5)->get();

      $log = DB::table('t_log')
              ->whereNotIn('t_log.tipe', [4])
              ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
              ->orderBy('t_log.created_at', 'DESC')
              ->select('t_log.*', 't_akun.foto')
              ->get();

      return view('pages.statistik.index')->with('arsip_retensi', $arsip_retensi)
                  ->with('arsip_akses', $arsip_akses)
                  ->with('arsip_unduh', $arsip_unduh)
                  ->with('arsip_cetak', $arsip_cetak)
                  ->with('arsip_aktif', $arsip_aktif)
                  ->with('arsip_inaktif', $arsip_inaktif)
                  ->with('arsip_statis', $arsip_statis)
                  ->with('arsip_musnah', $arsip_musnah)
                  ->with('arsip_lain', $arsip_lain)
                  ->with('log', $log);
    }

    public function jumlaharsip(){
      $arsip_aktif = Arsip::where('status', 1)->count();
      $arsip_inaktif = Arsip::where('status', 2)->count();
      $arsip_statis = Arsip::where('status', 3)->count();
      $arsip_musnah = Arsip::where('status', 0)->count();
      $arsip_lain = Arsip::where('status', 4)->count();

      $data = array(
        'arsip_aktif' => $arsip_aktif,
        'arsip_inaktif' => $arsip_inaktif,
        'arsip_statis' => $arsip_statis,
        'arsip_musnah' => $arsip_musnah,
        'arsip_lain' => $arsip_lain
      );

      return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Log;
use DB;

class LogController extends Controller
{
  public function index(){
    $log = DB::table('t_log')
            ->whereNotIn('t_log.tipe', [4])
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->get();
    $lain = Log::where('tipe', 0)->count();
    $arsip = Log::where('tipe', 1)->count();
    $akun = Log::where('tipe', 2)->count();
    $kategori = Log::where('tipe', 3)->count();

    return view('pages.log.index')->with('log', $log)
                      ->with('lain', $lain)
                      ->with('arsip', $arsip)
                      ->with('akun', $akun)
                      ->with('kategori', $kategori);
  }
}

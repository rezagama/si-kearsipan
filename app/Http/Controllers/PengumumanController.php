<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\Pengumuman;
use Redirect;
use Auth;
use DB;

class PengumumanController extends Controller
{
    public function index(){
      $pengumuman = DB::table('t_pengumuman')
                      ->join('t_akun', 't_pengumuman.id_user', '=', 't_akun.id_user')
                      ->select('t_pengumuman.*', 't_akun.nama', 't_akun.id_user')
                      ->get();

      return view('pages.pengumuman.index')->with('pengumuman', $pengumuman);
    }

    public function show($id){
      $pengumuman = DB::table('t_pengumuman')->where('id_pengumuman', $id)
                      ->join('t_akun', 't_pengumuman.id_user', '=', 't_akun.id_user')
                      ->select('t_pengumuman.*', 't_akun.nama', 't_akun.id_user')
                      ->first();

      return view('pages.pengumuman.detail')->with('pengumuman', $pengumuman);
    }

    public function compose(){
      return view('pages.pengumuman.compose');
    }

    public function store(Request $request){
      $pengumuman = new Pengumuman;
      $pengumuman->id_pengumuman = App::generateUniqueID();
      $pengumuman->id_user = Auth::user()->id_user;
      $pengumuman->judul_pengumuman = $request->input('judul');
      $pengumuman->isi_pengumuman = $request->input('isi');

      if($pengumuman->save()){
        return Redirect::back()->with('info', 'Pengumuman berhasil ditambahkan.');
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }

    public function edit($id){
      $pengumuman = Pengumuman::where('id_pengumuman', $id)->first();
      return view('pages.pengumuman.edit')->with('pengumuman', $pengumuman);
    }

    public function update(Request $request, $id){
      $pengumuman = Pengumuman::where('id_pengumuman', $id)->first();

      $pengumuman->judul_pengumuman = $request->input('judul');
      $pengumuman->isi_pengumuman = $request->input('isi');

      if($pengumuman->save()){
        return Redirect::back()->with('info', 'Pengumuman berhasil diperbarui.');
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }

    public function delete($id){
      $pengumuman = Pengumuman::where('id_pengumuman', $id)->first();

      if($pengumuman->delete()){
        return Redirect::back()->with('info', 'Pengumuman berhasil dihapus.');
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }
}

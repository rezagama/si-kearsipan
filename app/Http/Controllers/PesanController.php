<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\IsiPesan;
use App\Pesan;
use App\User;
use Redirect;
use Auth;
use DB;

class PesanController extends Controller
{
    public function pesanmasuk(){
      $id = Auth::user()->id_user;
      $title = 'Pesan Masuk';
      $pesan = DB::table('t_pesan')->where('id_penerima', $id)
                  ->join('t_akun', 't_pesan.id_pengirim', '=', 't_akun.id_user')
                  ->select('t_pesan.*', 't_akun.foto', 't_akun.id_user', 't_akun.nama')
                  ->get();

      $pesanmasuk = Pesan::where('id_penerima', $id)->where('status', 0)->count();
      $pesankeluar = Pesan::where('id_pengirim', $id)->count();

      return view('pages.pesan.index')->with('pesan', $pesan)
                  ->with('pesanmasuk', $pesanmasuk)
                  ->with('pesankeluar', $pesankeluar)
                  ->with('title', $title);
    }

    public function pesankeluar(){
      $id = Auth::user()->id_user;
      $title = 'Pesan Terkirim';
      $pesan = DB::table('t_pesan')->where('id_pengirim', $id)
                  ->join('t_akun', 't_pesan.id_pengirim', '=', 't_akun.id_user')
                  ->select('t_pesan.*', 't_akun.foto', 't_akun.id_user', 't_akun.nama')
                  ->get();

      $pesanmasuk = Pesan::where('id_penerima', $id)->where('status', 0)->count();
      $pesankeluar = Pesan::where('id_pengirim', $id)->count();

      return view('pages.pesan.index')->with('pesan', $pesan)
                  ->with('pesanmasuk', $pesanmasuk)
                  ->with('pesankeluar', $pesankeluar)
                  ->with('title', $title);
    }

    public function show($id){
      $id_user = Auth::user()->id_user;
      $pesan = Pesan::where('id_pesan', $id)->first();
      $isi_pesan = IsiPesan::where('id_pesan', $id)->get();

      foreach ($isi_pesan as $key => $value) {
        $isi_pesan = IsiPesan::where('id_isi_pesan', $value->id_isi_pesan)->first();
        if($isi_pesan->status == 0 && $isi_pesan->id_user != $id_user){
          $isi_pesan->status = 1;
          $isi_pesan->save();
        }
      }

      if($id_user != $pesan->id_pengirim && $pesan->status == 0){
        $pesan->status = 1;
        $pesan->save();
      }

      $isi_pesan = DB::table('t_isi_pesan')->where('id_pesan', $id)
                  ->join('t_akun', 't_isi_pesan.id_user', '=', 't_akun.id_user')
                  ->select('t_isi_pesan.*', 't_akun.foto', 't_akun.nama', 't_akun.id_user')
                  ->orderBy('t_isi_pesan.updated_at', 'ASC')
                  ->get();

      if($pesan->id_penerima == $id_user){
        $title = 'Pesan Masuk';
        $user = User::where('id_user', $pesan->id_pengirim)->first();
      } else {
        $title = 'Pesan Keluar';
        $user = User::where('id_user', $pesan->id_penerima)->first();
      }

      return view('pages.pesan.detail')->with('isi_pesan', $isi_pesan)
                  ->with('user', $user)
                  ->with('pesan', $pesan)
                  ->with('title', $title);
    }

    public function balas(Request $request, $id){
      $isi_pesan = $request->input('isi_pesan');

      $pesan = new IsiPesan;
      $pesan->id_isi_pesan = App::generateUniqueId();
      $pesan->id_pesan = $id;
      $pesan->id_user = Auth::user()->id_user;
      $pesan->isi_pesan = $isi_pesan;
      $pesan->status = 0;

      if($pesan->save()){
        $pesan = Pesan::where('id_pesan', $id)->first();
        $pesan->status = 0;
        if($pesan->save()){
          return Redirect::back()->with('info', 'Pesan berhasil dikirim.');
        } else {
          return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
        }
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }

    public function compose(Request $request){
      $id = Auth::user()->id_user;
      $user = User::orderBy('nama', 'ASC')->get();
      $pesanmasuk = Pesan::where('id_penerima', $id)->where('status', 0)->count();
      $pesankeluar = Pesan::where('id_pengirim', $id)->count();

      return view('pages.pesan.compose')->with('user', $user)
                      ->with('pesanmasuk', $pesanmasuk)
                      ->with('pesankeluar', $pesankeluar);
    }

    public function store(Request $request){
      $judul = $request->input('judul');
      $id_pesan = App::generateUniqueId();
      $id_pengirim = Auth::user()->id_user;
      $id_penerima = $request->input('kepada');
      $isi = $request->input('isi_pesan');

      $pesan = new Pesan;
      $pesan->id_pesan = $id_pesan;
      $pesan->id_pengirim = $id_pengirim;
      $pesan->id_penerima = $id_penerima;
      $pesan->judul_pesan = $judul;
      $pesan->isi_pesan = $isi;
      $pesan->status = 0;

      if($pesan->save()){
        $pesan = new IsiPesan;
        $pesan->id_isi_pesan = App::generateUniqueId();
        $pesan->id_pesan = $id_pesan;
        $pesan->id_user = $id_pengirim;
        $pesan->isi_pesan = $isi;
        $pesan->status = 0;

        if($pesan->save()){
          return Redirect::back()->with('info', 'Pesan berhasil dikirim.');
        } else {
          return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
        }
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }

    public function edit($id){
      $id_user = Auth::user()->id_user;
      $pesanmasuk = Pesan::where('id_penerima', $id_user)->where('status', 0)->count();
      $pesankeluar = Pesan::where('id_pengirim', $id_user)->count();

      $pesan = DB::table('t_isi_pesan')->where('id_isi_pesan', $id)
                  ->join('t_pesan', 't_isi_pesan.id_pesan', '=', 't_pesan.id_pesan')
                  ->select('t_isi_pesan.*', 't_pesan.judul_pesan', 't_pesan.id_penerima')
                  ->first();

      return view('pages.pesan.edit')->with('pesan', $pesan)
                  ->with('pesanmasuk', $pesanmasuk)
                  ->with('pesankeluar', $pesankeluar);
    }

    public function update(Request $request, $id){
      $pesan = IsiPesan::where('id_isi_pesan', $id)->first();
      $pesan->isi_pesan = $request->input('isi_pesan');

      if($pesan->status == 0){
        $pesan->status = 3;
      } else {
        $pesan->status = 4;
      }

      if($pesan->save()){
        return Redirect::route('pesan.show', $pesan->id_pesan)->with('info', 'Pesan berhasil diperbarui.');
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }

    public function delete($id){
      $pesan = Pesan::where('id_pesan', $id)->first();

      if($pesan->delete()){
        return Redirect::back()->with('info', 'Pesan berhasil dihapus.');
      } else {
        return Redirect::back()->with('error', 'Telah terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    }
}

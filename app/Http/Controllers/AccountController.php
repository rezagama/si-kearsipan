<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\User;
use Redirect;
use Validator;
use DB;

class AccountController extends Controller
{
  public function show($id){
    $user = User::where('id_user', $id)->first();
    $log = DB::table('t_log')
            ->where('t_log.id_user', $id)
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->get();

    return view('pages.akun.detail')->with('user', $user)
                ->with('log', $log);
  }

  public function edit($id){
    $user = User::where('id_user', $id)->first();
    $log = DB::table('t_log')
            ->where('t_log.id_user', $id)
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->get();

    return view('pages.akun.edit')->with('user', $user)
                ->with('log', $log);
  }

  public function update(Request $request, $id){
    $user = User::where('id_user', $id)->first();

    $nama = $request->input('nama');
    $nip = $request->input('nip');
    $email = $request->input('email');
    $jenis_kelamin = $request->input('jenis_kelamin');
    $tgl_lahir = $request->input('tgl_lahir');
    $no_hp = $request->input('no_hp');
    $password = $request->input('password');
    $ulang_password = $request->input('ulang_password');
    $alamat = $request->input('alamat');
    $foto = $request->file('foto');

    if($password != ''){
      if($password == $ulang_password){
        $hash = App::generatePasswordHash($password);
        $user->password = $hash;
      } else {
        return Redirect::back()->with('error', 'Password yang anda masukkan tidak sama.');
      }
    }

    $v = Validator::make($request->all(), [
      'nip' => 'required',
    ]);

    if($user->nip != $nip){
      $v = Validator::make($request->all(), [
        'nip' => 'unique:t_akun|min:18|max:18',
      ]);
    }

    if($user->email != $email){
      $v = Validator::make($request->all(), [
        'email' => 'unique:t_akun',
      ]);
    }

    if($user->nip != $nip && $user->email != $email){
      $v = Validator::make($request->all(), [
        'nip' => 'unique:t_akun|min:18|max:18',
        'email' => 'unique:t_akun'
      ]);
    }

    if(!$v->fails()){
      $user->nama = $nama;
      $user->nip = $nip;
      $user->email = $email;
      $user->jenis_kelamin = $jenis_kelamin;
      $user->alamat = $alamat;
      $user->no_hp = $no_hp;
      $user->tgl_lahir = App::formatDate($tgl_lahir);

      if(isset($foto)){
        $path = 'img/profile';
        $filename = App::getFileName($foto, $nip, $path);
        if($foto->move($path, $filename)){
          App::hapusFoto($user);
          $user->foto = $path.'/'.$filename;
        }
      }

      if($user->save()){
        return Redirect::back()->with('info', 'Akun '. $nama.' berhasil diperbarui.');
      } else {
        return Redirect::back()->with('error', 'Terjadi kesalahan dalam sistem. Harap coba beberapa saat lagi.');
      }
    } else {
      return Redirect::back()->with('error', $v->errors()->all()[0]);
    }
  }
}

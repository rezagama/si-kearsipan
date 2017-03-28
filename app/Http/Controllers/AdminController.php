<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\User;
use Validator;
use Redirect;
use Auth;

class AdminController extends Controller
{
    public function index(){
      $admin = User::where('level', 0)->orderBy('created_at', 'DESC')->get();
      return view('pages.akun.admin.index')->with('admin', $admin);
    }

    public function store(Request $request){
      $nama = $request->input('nama');
      $nip = $request->input('nip');
      $email = $request->input('email');
      $foto = $request->file('foto');
      $level = 0;

      $v = Validator::make($request->all(), [
        'nip' => 'unique:t_akun|min:18|max:18',
        'foto' => 'image',
        'email' => 'unique:t_akun'
      ]);

      if(!$v->fails()){
        $uid = App::generateUniqueID();
        $password = App::generatePassword();
        $hash = App::generatePasswordHash($password);

        $user = new User;
        $user->id_user = $uid;
        $user->nama = $nama;
        $user->nip = $nip;
        $user->email = $email;
        $user->level = $level;
        $user->password = $hash;

        if(isset($foto)){
          $path = 'img/profile';
          $filename = App::getFileName($foto, $nip, $path);
          if($foto->move($path, $filename)){
            $user->foto = $path.'/'.$filename;
          }
        } else {
          $user->foto = 'img/profile.jpg';
        }

        if($user->save()){

          $data = array(
            'deskripsi' => Auth::user()->nama.' menambahkan '. $nama.' ['.$nip.'] sebagai Admin.',
            'url' => $user->id_user,
            'option' => 'akun'
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', $nama.' '.' berhasil ditambahkan sebagai Admin.'.' '.$password);
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan dalam sistem. Harap coba beberapa saat lagi.');
        }
      } else {
        return Redirect::back()->with('error', $v->errors()->all()[0]);
      }
    }

    public function status($id, $status){
      $user = User::where('id_user', $id)->first();

      if($user){
        $msg = App::getStatusMessage($user, $status);
        $user->status = $status;

        if($user->save()){
          $data = array(
            'deskripsi' => Auth::user()->nama.' telah '.App::getUserStatus($status).' akun '. $user->nama.' ['.$user->nip.'].',
            'url' => $user->id_user,
            'option' => 'akun'
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', $msg);
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan sistem, harap coba beberapa saat lagi.');
        }

      } else {
        return Redirect::back()->with('error', 'Akun tidak ditemukan.');
      }
    }

    public function level($id, $level){
      $user = User::where('id_user', $id)->first();
      if($user){
        $msg = App::getLevelMessage($user, $level);
        $user->level = $level;

        if($user->save()){
          $data = array(
            'deskripsi' => Auth::user()->nama.' merubah akun '. $user->nama.' ['.$user->nip.'] menjadi '. App::getUserRole($level) .'.',
            'url' => $user->id_user,
            'option' => 'akun'
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', $msg);
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan sistem, harap coba beberapa saat lagi.');
        }

      } else {
        return Redirect::back()->with('error', 'Akun tidak ditemukan.');
      }
    }

    public function destroy($id){
      $user = User::where('id_user', $id)->first();
      $nama = $user->nama;
      $nip = $user->nip;
      if($user){
        if(App::deleteUser($user)){
          $data = array(
            'deskripsi' => Auth::user()->nama.' menghapus akun '. $nama.' ['.$nip.'].',
            'url' => null,
            'option' => 'akun',
            'delete' => $id
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', 'Akun dengan NIP '.$nip.' berhasil dihapus.');
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan sistem, harap coba beberapa saat lagi.');
        }
      } else {
        return Redirect::back()->with('error', 'Akun dengan NIP '.$nip.' tidak ditemukan.');
      }
    }
}

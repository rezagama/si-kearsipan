<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\App;
use App\User;
use Validator;
use Redirect;
use Auth;

class StaffController extends Controller
{
  public function index(){
    $staff = User::where('level', 1)->orderBy('created_at', 'DESC')->get();
    return view('pages.akun.staff.index')->with('staff', $staff);
  }

  public function store(Request $request){
    $nama = $request->input('nama');
    $nip = $request->input('nip');
    $email = $request->input('email');
    $foto = $request->file('foto');
    $level = 1;

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
          'deskripsi' => Auth::user()->nama.' menambahkan '. $nama.' ['.$nip.'] sebagai Staff.',
          'url' => $user->id_user,
          'option' => 'akun'
        );

        App::saveSystemLog($data);

        return Redirect::back()->with('info', $nama.' '.' berhasil ditambahkan sebagai staff.'.' '.$password);
      } else {
        return Redirect::back()->with('error', 'Terjadi kesalahan dalam sistem. Harap coba beberapa saat lagi.');
      }
    } else {
      return Redirect::back()->with('error', $v->errors()->all()[0]);
    }
  }
}

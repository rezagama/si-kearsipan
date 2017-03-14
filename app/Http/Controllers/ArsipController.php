<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\App;
use App\Http\Requests;
use App\Kategori;
use App\Arsip;
use Validator;
use Redirect;
use Auth;
use File;
use DB;

class ArsipController extends Controller
{
  public function index(){
    $arsip = Kategori::where('parent', null)->get();
    $count = Kategori::where('parent', null)->count();
    $title = 'Sistem Informasi Kearsipan / Daftar Arsip';
    return view('pages.arsip.index')->with('arsip', $arsip)
                ->with('panel', 'Daftar Arsip')
                ->with('title', $title)
                ->with('count', $count)
                ->with('id', null);
  }

  public function show($id){
    $arsip = Kategori::where('parent', $id)->get();
    $count = Kategori::where('parent', $id)->count();
    $folder = Kategori::where('id_kategori', $id)->first();
    $path  = App::getDocumentPath($folder);
    $size = App::getPathCount($path);

    $title = 'Sistem Informasi Kearsipan / Daftar Arsip / '.$folder->nama_kategori;
    return view('pages.arsip.index')->with('arsip', $arsip)
                ->with('path', $path)->with('size', $size)
                ->with('panel', $folder->nama_kategori)
                ->with('title', $title)
                ->with('count', $count)
                ->with('id', $id);
  }

  public function store(Request $request){
    $judul = $request->input('judul');
    $kategori = $request->input('kategori');
    $noarsip = $request->input('no_arsip');
    $retensi = $request->input('jra');
    $deskripsi = $request->input('deskripsi');
    $file = $request->file('dokumen');

    $v = Validator::make($request->all(), [
      'no_arsip' => 'unique:t_arsip'
    ]);

    if(!$v->fails()){
      if(isset($file)){
        $arsip = new Arsip;
        $arsip->id_kategori = $kategori;
        $arsip->id_user = Auth::user()->id_user;
        $arsip->id_arsip = App::generateUniqueID();
        $arsip->no_arsip = $noarsip;
        $arsip->judul = $judul;
        $arsip->jadwal_retensi = App::formatDate($retensi);
        $arsip->deskripsi = $deskripsi;

        $kategori = Kategori::where('id_kategori', $kategori)->first();
        $docpath = preg_replace('/\s+/', '', App::getArchiveRoot($kategori));
        $arsip->status = App::getDocumentStatus($kategori);

        $path = 'dokumen/'.strtolower($docpath);
        $filename = App::getFileName($file, $judul, $path);
        if($file->move($path, $filename)){
          $arsip->file = $path.'/'.$filename;
        }

        if($arsip->save()){
          return Redirect::back()->with('info', $judul.' '.' berhasil ditambahkan ke dalam folder '. $kategori->nama_kategori);
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan dalam sistem. Harap coba beberapa saat lagi.');
        }
      } else {
        return Redirect::back()->with('error', 'fail');
      }
    } else {
      return Redirect::back()->with('error', $v->errors()->all()[0]);
    }
  }

  public function update(Request $request, $id){
    $arsip = Arsip::where('id_arsip', $id)->first();

    $judul = $request->input('judul');
    $noarsip = $request->input('no_arsip');
    $id_kategori = $request->input('kategori');
    $retensi = $request->input('jra');
    $deskripsi = $request->input('deskripsi');
    $file = $request->file('dokumen');

    $id = $request->input('root');
    $root = Kategori::where('id_kategori', $id)->first();

    $kategori = Kategori::where('id_kategori', $arsip->id_kategori)->first();
    $archive = App::getArchiveRootId($kategori);

    if($arsip->no_arsip == $noarsip){
      $v = Validator::make($request->all(), [
        'no_arsip' => 'required'
      ]);
    } else {
      $v = Validator::make($request->all(), [
        'no_arsip' => 'unique:t_arsip'
      ]);
    }

    if(!$v->fails()){
      $arsip->judul = $judul;
      $arsip->no_arsip = $noarsip;
      $arsip->deskripsi = $deskripsi;
      $arsip->jadwal_retensi = App::formatDate($retensi);

      if($archive != $root->id_kategori){
        $folder = Kategori::where('id_kategori', $id_kategori)->first();
        $arsip->id_kategori = App::copyArchiveFolder($folder, $root);
        $arsip->status = $root->tipe_kategori;
      }

      if(isset($file)){
        App::hapusFileArsip($arsip);
        $docpath = preg_replace('/\s+/', '', App::getArchiveRoot($kategori));
        $path = 'dokumen/'.strtolower($docpath);
        $filename = App::getFileName($file, $judul, $path);
        if($file->move($path, $filename)){
          $arsip->file = $path.'/'.$filename;
        }
      }

      if($arsip->save()){
        return Redirect::back()->with('info', 'Perubahan arsip berhasil disimpan.');
      } else {
        return Redirect::back()->with('error', 'Terjadi kesalahan dalam sistem. Harap coba beberapa saat lagi.');
      }
    } else {
      return Redirect::back()->with('error', $v->errors()->all()[0]);
    }
  }

  public function dokumen($id){
    $arsip = DB::table('t_arsip')
            ->where('id_kategori', $id)
            ->join('t_akun', 't_arsip.id_user', '=', 't_akun.id_user')
            ->select('t_arsip.*', 't_akun.nama')
            ->get();
    $kategori = Kategori::where('parent', $id)->get();
    $folder = Kategori::where('id_kategori', $id)->first();
    $path  = App::getArchivePath($folder);
    $size = App::getPathCount($path);

    $title = 'Sistem Informasi Kearsipan / Arsip / '.$folder->nama_kategori;
    return view('pages.arsip.dokumen')->with('arsip', $arsip)->with('kategori', $kategori)
                ->with('path', $path)->with('size', $size)
                ->with('folder', $folder)
                ->with('title', $title)
                ->with('id', $id);
  }

  public function detail($id){
    $arsip = DB::table('t_arsip')
            ->where('id_arsip', $id)
            ->join('t_akun', 't_arsip.id_user', '=', 't_akun.id_user')
            ->join('t_kategori', 't_arsip.id_kategori', '=', 't_kategori.id_kategori')
            ->select('t_arsip.*', 't_akun.nama', 't_akun.id_user', 't_kategori.nama_kategori')
            ->first();
    $log = DB::table('t_riwayat')
            ->where('id_arsip', $id)
            ->join('t_log', 't_riwayat.id_log', '=', 't_log.id_log')
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->get();
    $kategori = Kategori::where('parent', $id)->get();
    $folder = Kategori::where('id_kategori', $arsip->id_kategori)->first();
    $path  = App::getArchivePath($folder);
    $size = App::getPathCount($path);

    return view('pages.arsip.detail')->with('arsip', $arsip)
                ->with('log', $log)
                ->with('path', $path)
                ->with('size', $size);
  }

  public function edit($id){
    $arsip = DB::table('t_arsip')
            ->where('id_arsip', $id)
            ->join('t_akun', 't_arsip.id_user', '=', 't_akun.id_user')
            ->join('t_kategori', 't_arsip.id_kategori', '=', 't_kategori.id_kategori')
            ->select('t_arsip.*', 't_akun.nama', 't_akun.id_user', 't_kategori.nama_kategori')
            ->first();
    $log = DB::table('t_riwayat')
            ->where('id_arsip', $id)
            ->join('t_log', 't_riwayat.id_log', '=', 't_log.id_log')
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->get();
    $kategori = Kategori::where('parent', null)->get();
    $folder = Kategori::where('id_kategori', $arsip->id_kategori)->first();
    $root = App::getArchiveRootId($folder);
    $path = App::getArchivePath($folder);
    $size = App::getPathCount($path);

    return view('pages.arsip.edit')->with('arsip', $arsip)
                ->with('kategori', $kategori)
                ->with('root', $root)
                ->with('log', $log)
                ->with('path', $path)
                ->with('size', $size);
  }

  public function download($id){
    $arsip = Arsip::where('id_arsip', $id)->first();
    $file = $arsip->file;

    if(File::exists($file)){
      return Redirect::to($file);
    } else {
      return Redirect::back()->with('error', 'File arsip '.$arsip->judul.' tidak ditemukan.');
    }
  }

  public function destroy($id){
    $arsip = Arsip::where('id_arsip', $id)->first();
    $judul = $arsip->judul;
    $no = $arsip->no_arsip;
    if($arsip){
      if(App::deleteArsip($arsip)){
        return Redirect::back()->with('info', $judul. ' dengan nomor arsip '.$no.' berhasil dihapus.');
      } else {
        return Redirect::back()->with('error', 'Terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    } else {
      return Redirect::back()->with('error', 'Arsip tidak ditemukan.');
    }
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\App;
use App\Http\Requests;
use App\Direktori;
use App\Arsip;
use Validator;
use Redirect;
use Auth;
use File;
use DB;

class ArsipController extends Controller
{
  public function index(){
    $arsip = Direktori::where('parent', null)->get();
    $count = Direktori::where('parent', null)->count();
    $title = 'Sistem Informasi Kearsipan / Daftar Arsip';
    return view('pages.arsip.index')->with('arsip', $arsip)
                ->with('panel', 'Direktori Arsip')
                ->with('title', $title)
                ->with('count', $count)
                ->with('id', null);
  }

  public function show($id){
    $arsip = Direktori::where('parent', $id)->get();
    $count = Direktori::where('parent', $id)->count();
    $folder = Direktori::where('id_direktori', $id)->first();
    $path  = App::getDocumentPath($folder);
    $size = App::getPathCount($path);

    $title = 'Sistem Informasi Kearsipan / Daftar Arsip / '.$folder->nama_direktori;
    return view('pages.arsip.index')->with('arsip', $arsip)
                ->with('path', $path)->with('size', $size)
                ->with('panel', $folder->nama_direktori)
                ->with('title', $title)
                ->with('count', $count)
                ->with('id', $id);
  }

  public function store(Request $request){
    $judul = $request->input('judul');
    $direktori = $request->input('direktori');
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
        $arsip->id_direktori = $direktori;
        $arsip->id_user = Auth::user()->id_user;
        $arsip->id_arsip = App::generateUniqueID();
        $arsip->no_arsip = $noarsip;
        $arsip->judul = $judul;
        $arsip->jadwal_retensi = App::formatDate($retensi);
        $arsip->deskripsi = $deskripsi;

        $direktori = Direktori::where('id_direktori', $direktori)->first();
        $docpath = preg_replace('/\s+/', '', App::getArchiveRoot($direktori));
        $arsip->status = App::getDocumentStatus($direktori);

        $path = 'dokumen/'.strtolower($docpath);
        $filename = App::getFileName($file, $judul, $path);
        if($file->move($path, $filename)){
          $arsip->file = $path.'/'.$filename;
        }

        if($arsip->save()){
          $data = array(
            'deskripsi' => Auth::user()->nama.' menambahkan '.$judul.' ke dalam direktori '.$direktori->nama_direktori.'.',
            'url' => $arsip->id_arsip,
            'option' => 'arsip'
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', $judul.' '.' berhasil ditambahkan ke dalam folder '. $direktori->nama_direktori);
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
    $id_direktori = $request->input('root');
    $retensi = $request->input('jra');
    $deskripsi = $request->input('deskripsi');
    $file = $request->file('dokumen');

    $input = Direktori::where('id_direktori', $id_direktori)->first();

    $direktori = Direktori::where('id_direktori', $arsip->id_direktori)->first();
    $archive = App::getArchiveRootId($direktori);
    $parent = $direktori->parent;

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

      if($parent != null){
        $arsip->id_direktori = App::copyArchiveFolder($direktori, $input);
        $arsip->status = $input->tipe_direktori;
      } else {
        $arsip->id_direktori = $id_direktori;
        $arsip->status = $input->tipe_direktori;
      }

      if(isset($file)){
        App::hapusFileArsip($arsip);
        $docpath = preg_replace('/\s+/', '', App::getArchiveRoot($direktori));
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
            ->where('id_direktori', $id)
            ->join('t_akun', 't_arsip.id_user', '=', 't_akun.id_user')
            ->select('t_arsip.*', 't_akun.nama')
            ->orderBy('t_arsip.created_at', 'DESC')
            ->get();
    $direktori = Direktori::where('parent', $id)->get();
    $folder = Direktori::where('id_direktori', $id)->first();
    $path  = App::getArchivePath($folder);
    $size = App::getPathCount($path);

    $title = 'Sistem Informasi Kearsipan / Arsip / '.$folder->nama_direktori;
    return view('pages.arsip.dokumen')->with('arsip', $arsip)->with('direktori', $direktori)
                ->with('path', $path)->with('size', $size)
                ->with('folder', $folder)
                ->with('title', $title)
                ->with('id', $id);
  }

  public function detail($id){
    $arsip = DB::table('t_arsip')
            ->where('id_arsip', $id)
            ->join('t_akun', 't_arsip.id_user', '=', 't_akun.id_user')
            ->join('t_direktori', 't_arsip.id_direktori', '=', 't_direktori.id_direktori')
            ->select('t_arsip.*', 't_akun.nama', 't_akun.id_user', 't_direktori.nama_direktori')
            ->first();
    $log = DB::table('t_riwayat')
            ->where('id_arsip', $id)
            ->join('t_log', 't_riwayat.id_log', '=', 't_log.id_log')
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->orderBy('t_log.created_at', 'DESC')
            ->get();
    $direktori = Direktori::where('parent', $id)->get();
    $folder = Direktori::where('id_direktori', $arsip->id_direktori)->first();
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
            ->join('t_direktori', 't_arsip.id_direktori', '=', 't_direktori.id_direktori')
            ->select('t_arsip.*', 't_akun.nama', 't_akun.id_user', 't_direktori.nama_direktori')
            ->first();
    $log = DB::table('t_riwayat')
            ->where('id_arsip', $id)
            ->join('t_log', 't_riwayat.id_log', '=', 't_log.id_log')
            ->join('t_akun', 't_log.id_user', '=', 't_akun.id_user')
            ->select('t_log.*', 't_akun.foto')
            ->orderBy('t_log.created_at', 'DESC')
            ->get();
    $direktori = Direktori::where('parent', null)->get();
    $folder = Direktori::where('id_direktori', $arsip->id_direktori)->first();
    $root = App::getArchiveRootId($folder);
    $path = App::getArchivePath($folder);
    $size = App::getPathCount($path);

    return view('pages.arsip.edit')->with('arsip', $arsip)
                ->with('direktori', $direktori)
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
        $data = array(
          'deskripsi' => Auth::user()->nama.' telah mengahpus arsip '.$judul.' dengan nomor arsip '.$no.'.',
          'url' => null,
          'option' => 'arsip',
          'delete' => true
        );

        App::saveSystemLog($data);

        return Redirect::back()->with('info', $judul. ' dengan nomor arsip '.$no.' berhasil dihapus.');
      } else {
        return Redirect::back()->with('error', 'Terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
      }
    } else {
      return Redirect::back()->with('error', 'Arsip tidak ditemukan.');
    }
  }
}

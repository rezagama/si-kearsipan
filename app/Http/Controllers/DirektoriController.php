<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Redirect;
use Validator;
use App\Http\Requests;
use App\Helpers\App;
use App\Direktori;
use App\User;

class DirektoriController extends Controller
{
    public function index(){
      $direktori = Direktori::where('parent', null)->get();
      $count = Direktori::where('parent', null)->count();
      $title = 'Sistem Informasi Kearsipan / Direktori Arsip';
      return view('pages.direktori.index')->with('direktori', $direktori)
                  ->with('panel', 'Direktori Arsip')
                  ->with('title', $title)
                  ->with('count', $count)
                  ->with('id', null);
    }

    public function show($id){
      $direktori = Direktori::where('parent', $id)->get();
      $count = Direktori::where('parent', $id)->count();
      $folder = Direktori::where('id_direktori', $id)->first();
      $path  = App::getDocumentPath($folder);
      $size = App::getPathCount($path);
      $title = 'Sistem Informasi Kearsipan / Direktori Arsip / '.$folder->nama_direktori;
      return view('pages.direktori.index')->with('direktori', $direktori)
                  ->with('path', $path)->with('size', $size)
                  ->with('panel', $folder->nama_direktori)
                  ->with('title', $title)
                  ->with('count', $count)
                  ->with('id', $id);
    }

    public function store(Request $request){
      $folder = $request->input('nama');
      $parent = $parent = App::isValueNull($request->input('parent'));

      $direktori = Direktori::where('nama_direktori', $folder)->where('parent', $parent)->first();

      if($direktori){
        if($parent == null) {
          return Redirect::back()->with('error', 'Direktori dengan nama '.$folder.' sudah tersedia.');
        } else {
          return Redirect::back()->with('error', 'Direktori dengan nama '.$folder.' sudah tersedia di dalam folder '.App::getArchiveRoot($direktori).'.');
        }
      } else {
        $direktori = new Direktori;
        $direktori->id_direktori = App::generateUniqueID();
        $direktori->parent = App::isValueNull($parent);
        $direktori->tipe_direktori = App::getCategoryType($parent);
        $direktori->root = App::getArchiveRootId($direktori);
        $direktori->nama_direktori = $folder;

        if($parent == null){
          $deskripsi = Auth::user()->nama.' telah menambahkan direktori '. $folder .'.';
        } else {
          $deskripsi = Auth::user()->nama.' telah menambahkan folder '. $folder .' ke dalam direktori '.App::getArchiveRoot($direktori).'.';
        }

        if($direktori->save()){
          $data = array(
            'deskripsi' => $deskripsi,
            'url' => $direktori->id_direktori,
            'option' => 'direktori'
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', 'Direktori '.$folder.' berhasil ditambahkan ke dalam folder '.App::getArchiveRoot($direktori).'.');
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
        }
      }
    }

    public function update(Request $request){
      $id = $request->input('id');
      $folder = $request->input('direktori');
      $parent = $request->input('parent');
      $direktori = Direktori::where('id_direktori', $id)->first();

      if($direktori){
        $v = Validator::make($request->all(), [
          'direktori' => 'required'
        ]);

        if($v->fails()){
          return Redirect::back()->with('error', $v->errors()->all()[0]);
        } else {
          if($direktori->nama_direktori != $folder){
            $archive = Direktori::where('nama_direktori', $folder)
                                ->where('parent', $parent)->first();

            if($archive){
              if($parent == null) {
                return Redirect::back()->with('error', 'Direktori dengan nama '.$folder.' sudah tersedia.');
              } else {
                return Redirect::back()->with('error', 'Direktori dengan nama '.$folder.' sudah tersedia di dalam folder '.App::getArchiveRoot($direktori).'.');
              }
            }
          }

          $direktori->nama_direktori = $folder;

          if($direktori->save()){
            return Redirect::back()->with('info', 'Perubahan pada folder berhasil disimpan.');
          } else {
            return Redirect::back()->with('error', 'Terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
          }
        }
      } else {
        return Redirect::back()->with('error', 'Direktori tidak ditemukan.');
      }
    }

    public function destroy(Request $request){
      $id = $request->input('id');
      $direktori = Direktori::where('id_direktori', $id)->first();
      $nama = $direktori->nama_direktori;
      if($direktori){
        if(App::removeCategory($direktori)){
          $data = array(
            'deskripsi' => Auth::user()->nama.' menghapus direktori '. $nama.'.',
            'url' => null,
            'option' => 'direktori',
            'delete' => $id
          );

          App::saveSystemLog($data);

          return Redirect::back()->with('info', 'Direktori '.$direktori->nama_direktori.' berhasil dihapus.');
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
        }
      } else {
        return Redirect::back()->with('error', 'Direktori tidak ditemukan.');
      }
    }
}

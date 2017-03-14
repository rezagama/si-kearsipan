<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\Http\Requests;
use App\Helpers\App;
use App\Kategori;
use App\User;

class KategoriController extends Controller
{
    public function index(){
      $kategori = Kategori::where('parent', null)->get();
      $count = Kategori::where('parent', null)->count();
      $title = 'Sistem Informasi Kearsipan / Kategori Arsip';
      return view('pages.kategori.index')->with('kategori', $kategori)
                  ->with('panel', 'Arsip')
                  ->with('title', $title)
                  ->with('count', $count)
                  ->with('id', null);
    }

    public function show($id){
      $kategori = Kategori::where('parent', $id)->get();
      $count = Kategori::where('parent', $id)->count();
      $folder = Kategori::where('id_kategori', $id)->first();
      $path  = App::getDocumentPath($folder);
      $size = App::getPathCount($path);
      $title = 'Sistem Informasi Kearsipan / Kategori Arsip / '.$folder->nama_kategori;
      return view('pages.kategori.index')->with('kategori', $kategori)
                  ->with('path', $path)->with('size', $size)
                  ->with('panel', $folder->nama_kategori)
                  ->with('title', $title)
                  ->with('count', $count)
                  ->with('id', $id);
    }

    public function store(Request $request){
      $folder = $request->input('nama');
      $parent = $parent = App::isValueNull($request->input('parent'));

      $kategori = Kategori::where('nama_kategori', $folder)->where('parent', $parent)->first();

      if($kategori){
        if($parent == null) {
          return Redirect::back()->with('error', 'Kategori dengan nama '.$folder.' sudah tersedia.');
        } else {
          return Redirect::back()->with('error', 'Kategori dengan nama '.$folder.' sudah tersedia di dalam folder '.App::getArchiveRoot($kategori).'.');
        }
      } else {
        $kategori = new Kategori;
        $kategori->id_kategori = App::generateUniqueID();
        $kategori->parent = App::isValueNull($parent);
        $kategori->tipe_kategori = App::getCategoryType($parent);
        $kategori->nama_kategori = $folder;

        if($kategori->save()){
          return Redirect::back()->with('info', $folder. ' berhasil ditambahkan.');
        } else {
          return Redirect::back()->with('error', 'Terjadi kesalahan pada sistem. Harap coba beberapa saat lagi.');
        }
      }
    }

    public function destroy(Request $request){

    }
}

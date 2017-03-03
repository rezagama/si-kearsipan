<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class KategoriArsipController extends Controller
{
    public function index(){
      return view('pages.kategori-arsip');
    }
}

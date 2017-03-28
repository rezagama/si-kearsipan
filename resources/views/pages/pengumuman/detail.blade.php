@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Tulis Pengumuman / '.$pengumuman->judul_pengumuman)

@section('css')
  <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a href="{{URL::route('pengumuman.index')}}">Pengumuman</a></li>
  <li><a class="active" href="{{URL::route('pengumuman.show', $pengumuman->id_pengumuman)}}">{{$pengumuman->judul_pengumuman}}</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Menu
      </div>
      <div class="list-group">
        <a href="{{URL::route('pengumuman.index')}}" class="list-group-item"><i class="fa fa-list"></i> Daftar Pengumuman</a>
        <a href="{{URL::route('pengumuman.compose')}}" class="list-group-item"><i class="fa fa-pencil"></i> Tulis Pengumuman</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
          {{$pengumuman->judul_pengumuman}} <a href="{{URL::route('pengumuman.edit', $pengumuman->id_pengumuman)}}" class="btn btn-warning btn-sm btn-panel-heading pull-right"><i class="fa fa-edit"></i></a>
        </div>
        <div class="panel-body">
          <p><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($pengumuman->created_at, 'l, d M Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($pengumuman->created_at))}} <i class="fa fa-user"></i> <a class="font-brown" href="{{URL::route('account.show', $pengumuman->id_user)}}">{{$pengumuman->nama}}</a></p>
          <p align="justify">{!! $pengumuman->isi_pengumuman !!}</p>
          <p align="right"><i class="fa fa-clock-o"></i> {{Carbon::parse($pengumuman->created_at)->diffForHumans()}}</p>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/pengumuman/compose.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection

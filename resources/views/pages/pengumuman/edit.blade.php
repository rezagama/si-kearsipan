@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Pengumuman / Edit Pengumuman')

@section('css')
  <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a href="{{URL::route('pengumuman.index')}}">Pengumuman</a></li>
  <li><a class="active" href="{{URL::route('pengumuman.compose')}}">Edit</a></li>
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
                {{$pengumuman->judul_pengumuman}}
        </div>
        <div class="panel-body">
          <form id="form" class="form" action="{{URL::route('pengumuman.update', $pengumuman->id_pengumuman)}}" method="POST" enctype="multipart/form-data">
            <div class="container-fluid no-spacing">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input id="judul" name="judul" type="text" class="form-control" placeholder="Judul" aria-describedby="basic-addon1" value="{{$pengumuman->judul_pengumuman}}" required data-parsley-errors-messages-disabled tabindex="1">
              </div>
            </div>
            <input name="_token" type="hidden" value="{{csrf_token()}}"/>
            <div class="input-group fit-width">
              <div id="reply-field">
              </div>
            </div>
            <textarea id="isi" name="isi" style="display: none;" required data-parsley-errors-messages-disabled>{{$pengumuman->isi_pengumuman}}</textarea>
            <button type="submit "class="btn btn-default pull-right vertical-spacing-sm"> <i class="fa fa-check"></i> Simpan</button>
          </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/pengumuman/edit.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection

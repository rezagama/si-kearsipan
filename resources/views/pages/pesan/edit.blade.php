@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / '.$pesan->judul_pesan.' / Edit Pesan')

@section('css')
  <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i>
  <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if($pesan->id_penerima == Auth::user()->id_user)
    <li><a href="{{URL::route('pesan.masuk')}}">Pesan Masuk</a></li>
  @else
    <li><a href="{{URL::route('pesan.keluar')}}">Pesan Keluar</a></li>
  @endif
  <li><a href="{{URL::route('pesan.show', $pesan->id_pesan)}}">{{$pesan->judul_pesan}}</a></li>
  <li><a class="active" href="{{URL::route('pesan.edit', $pesan->id_isi_pesan)}}">Edit Pesan</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Menu
      </div>
      <div class="list-group">
        <a href="{{URL::route('pesan.masuk')}}" class="list-group-item"><i class="fa fa-envelope"></i> Pesan Masuk <span class="badge">{{$pesanmasuk}}</span></a></a>
        <a href="{{URL::route('pesan.keluar')}}" class="list-group-item"><i class="fa fa-envelope-open"></i> Pesan Terkirim<span class="badge">{{$pesankeluar}}</span></a>
        <a href="{{URL::route('pesan.compose')}}" class="list-group-item"><i class="fa fa-pencil"></i> Tulis Pesan</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Edit Pesan
        </div>
        <div class="panel-body">
          <form id="form" class="form" action="{{URL::route('pesan.update', $pesan->id_isi_pesan)}}" method="POST" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{csrf_token()}}"/>
            <div class="input-group fit-width">
              <div id="reply-field">
              </div>
            </div>
            <textarea id="isi_pesan" name="isi_pesan" style="display: none;" required data-parsley-errors-messages-disabled>{{$pesan->balasan}}</textarea>
            <button type="submit "class="btn btn-default pull-right vertical-spacing-sm"> <i class="fa fa-check"></i> Simpan</button>
          </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/pesan/edit.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection

@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Tulis Pesan')

@section('css')
  <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a class="active" href="{{URL::route('pesan.compose')}}">Tulis Pesan</a></li>
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
        <a href="{{URL::route('pesan.compose')}}" class="list-group-item active"><i class="fa fa-pencil"></i> Tulis Pesan</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Pesan Baru
        </div>
        <div class="panel-body">
          <form id="form" class="form" action="{{URL::route('pesan.store')}}" method="POST" enctype="multipart/form-data">
            <div class="container-fluid no-spacing">
              <div class="col-md-6 no-spacing">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                  <input id="judul" name="judul" type="text" class="form-control" placeholder="Judul" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                  <select id="kepada" name="kepada" class="form-control" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
                    <option value="">Kepada</option>
                    @foreach($user as $user)
                      @if(Auth::user()->nip != $user->nip)
                        <option value="{{$user->id_user}}">{{$user->nama}} ({{$user->nip}})</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <input name="_token" type="hidden" value="{{csrf_token()}}"/>
            <div class="input-group fit-width">
              <div id="reply-field">
              </div>
            </div>
            <textarea id="isi_pesan" name="isi_pesan" style="display: none;" required data-parsley-errors-messages-disabled></textarea>
            <button type="submit "class="btn btn-default pull-right vertical-spacing-sm"> <i class="fa fa-paper-plane"></i> Kirim</button>
          </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/pesan/compose.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection

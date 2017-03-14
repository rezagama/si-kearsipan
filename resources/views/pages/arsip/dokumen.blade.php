@extends('layouts.main')

@section('title', $title)

@section('css')
  <link href="{{url('css/bootstrap-datepicker.css')}}" rel="stylesheet"/>
  <link href="{{url('css/picker/picker-default.css')}}" rel="stylesheet"/>
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if(isset($path))
  <li><a href="{{URL::route('arsip.index')}}">Daftar Arsip</a></li>
    @for ($i = $size; $i >= 0; $i--)
      @if($i == 0)
        <li><a href="{{URL::route('arsip.dokumen', $path[$i]['url'])}}" class="active">{{$path[$i]['title']}}</a></li>
      @else
        <li><a href="{{URL::route('arsip.show', $path[$i]['url'])}}">{{$path[$i]['title']}}</a></li>
      @endif
    @endfor
  @else
    <li><a class="active" href="{{URL::route('arsip.index')}}">Daftar Arsip</a></li>
  @endif
</ol>
<div class="row v-spacing">
  <div class="col-sm-4 col-md-4 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Kelola Arsip
      </div>
      <form id="form" action="{{URL::route('arsip.store')}}" method="POST" enctype="multipart/form-data">
        <div class="panel-body">
          <div class="container-fluid no-spacing">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-file-text"></i></span>
              <input id="judul" name="judul" type="text" class="form-control" placeholder="Judul Arsip" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-edit"></i></span>
              <input id="no_arsip" name="no_arsip" type="text" maxlength="18" class="form-control" placeholder="Nomor Arsip" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="2">
            </div>
            <div class="input-group date" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input id="jra" name="jra" type="text" class="form-control" placeholder="Jadwal Retensi Arsip" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="3">
            </div>
            @if(Auth::user()->level == 1)
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
              <select id="pencipta" name="pencipta" class="form-control" aria-describedby="basic-addon1" tabindex="4" required data-parsley-errors-messages-disabled>
                <<option value="">Pencipta Arsip</option>
                <option>Mustard</option>
                <option>Ketchup</option>
                <option>Relish</option>
              </select>
            </div>
            @endif
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <textarea id="deskripsi" name="deskripsi" class="form-control custom-control" rows="5" style="resize:none" placeholder="Deskripsi arsip ..." tabindex="3"></textarea>
            </div>
          </div>
          <div class="container-fluid no-spacing">
            <div class="col-md-7 no-spacing">
              <div class="input-group">
                  <input id="filelabel" name="filelabel" type="text" class="form-control" value="File belum dipilih"readonly>
                  <label class="input-group-btn">
                      <span class="btn btn-default" tabindex="4">
                          Pilih File <input id="dokumen" name="dokumen" type="file" style="display: none;">
                      </span>
                  </label>
              </div>
            </div>
            <input type="hidden" name="kategori" value="{{$folder->id_kategori}}"/>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="col-md-5 no-spacing">
                <div class="input-group pull-right">
                  <button class="btn btn-default add pull-right" type="submit" tabindex="8"><i class="fa fa-plus"></i> Tambahkan Arsip</a>
                </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-sm-8 col-md-8 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        {{$folder->nama_kategori}}
      </div>
      <div class="panel-body">
        <table class="table table-hover data-table">
            <thead>
              <tr role="row">
                <th class="th-sm">No.</th>
                <th>No. Arsip</th>
                <th class="th-md">Judul</th>
                <th>Jadwal Retensi</th>
                <th>Pencipta Arsip</th>
                <th hidden></th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1 ?>
              @foreach($arsip as $arsip)
                <tr id="row" role="row" data-id="{{$arsip->id_user}}">
                  <td><div class="checkbox"> <input id="select" name="select" type="checkbox" value="{{$arsip->id_user}}" class="inline"> {{$i++}}</div>.</td>
                  <td>{{$arsip->no_arsip}}</td>
                  <td>{{$arsip->judul}}</td>
                  <td>{{date('D, d M Y', strtotime($arsip->jadwal_retensi))}}</td>
                  <td>{{$arsip->nama}}</td>
                  <td>
                    @if(Auth::user()->level == 0)
                    <form action="{{URL::route('arsip.hapus', $arsip->id_arsip)}}" class="inline" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus arsip ini?');">
                      <input type="hidden" name="_method" value="DELETE"></input>
                      <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                      <button type="submit" class="btn btn-danger btn-sm btn-sm-spacing"><i class="fa fa-trash"></i></button>
                    </form>
                    @endif
                    <a href="{{URL::route('arsip.download', $arsip->id_arsip)}}" class="btn btn-info btn-sm btn-sm-spacing" target="_blank"><i class="fa fa-cloud-download"></i></a>
                    <a href="{{URL::route('arsip.edit', $arsip->id_arsip)}}" class="btn btn-primary btn-sm btn-sm-spacing"><i class="fa fa-edit"></i></a>
                    <a href="{{URL::route('arsip.detail', $arsip->id_arsip)}}" type="button" class="btn btn-success btn-sm btn-sm-spacing"><i class="fa fa-chevron-right"></i></a>
                  </td>
                </tr>
              @endforeach
          </table>
          <div class="container-fluid controls-button" hidden>
            <label id="count">0 arsip terpilih </label> <a id="deleteBtn" name="deleteBtn" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"> Hapus</i></a>
          </div>
      </div>
    </div>
  <div>
</div>
@endsection
@section('script')
<!-- Datatables-->
<script src="{{asset('js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/datatables/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('js/datatables/tableconfig.min.js')}}"></script>
<script src="{{asset('js/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('js/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/datatables/responsive.bootstrap.min.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('js/picker.js')}}"></script>
<!-- Datatables-->

<script>
  var handleDataTableButtons = function() {
      "use strict";
      0 !== $(".data-table").length && $(".data-table").DataTable({
        dom: "Bfrtip",
        buttons: [{
          extend: "copy",
          className: "btn-sm"
        }, {
          extend: "csv",
          className: "btn-sm"
        }, {
          extend: "excel",
          className: "btn-sm"
        },
        {
          extend: "pdf",
          className: "btn-sm"
        },
        {
          extend: "print",
          className: "btn-sm"
        }],
        responsive: !0
      })
    },
    TableManageButtons = function() {
      "use strict";
      return {
        init: function() {
          handleDataTableButtons()
        }
      }
    }();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatable-keytable').DataTable({
      keys: true
    });
    $('#datatable-responsive').DataTable();
    $('#datatable-scroller').DataTable({
      ajax: "js/datatables/json/scroller-demo.json",
      deferRender: true,
      scrollY: 380,
      scrollCollapse: true,
      scroller: true
    });
    var table = $('#datatable-fixed-header').DataTable({
      fixedHeader: false
    });
  });
  TableManageButtons.init();
</script>

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection

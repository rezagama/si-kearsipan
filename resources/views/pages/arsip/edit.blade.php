@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Daftar Arsip / Edit / '. $arsip->judul)

@section('css')
  <link href="{{url('css/bootstrap-datepicker.css')}}" rel="stylesheet"/>
  <link href="{{url('css/picker/picker-sm.css')}}" rel="stylesheet"/>
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if(isset($path))
  <li><a href="{{URL::route('arsip.index')}}">Daftar Arsip</a></li>
    @for ($i = $size; $i >= 0; $i--)
      @if($i == 0)
        <li><a href="{{URL::route('arsip.dokumen', $path[$i]['url'])}}">{{$path[$i]['title']}}</a></li>
      @else
        <li><a href="{{URL::route('arsip.show', $path[$i]['url'])}}">{{$path[$i]['title']}}</a></li>
      @endif
    @endfor
  @else
    <li><a class="active" href="{{URL::route('arsip.index')}}">Daftar Arsip</a></li>
  @endif
  <li><a href="{{URL::route('arsip.detail', $arsip->id_arsip)}}">{{$arsip->judul}}</a></li>
  <li class="active">Edit</li>
</ol>
<div class="row v-spacing">
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Edit Arsip
      </div>
      <div class="panel-body">
        <form id="form" action="{{URL::route('arsip.update', $arsip->id_arsip)}}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Apakah anda yakin ingin menyimpan perubahan pada arsip ini?');">
          <div class="container-fluid no-spacing">
            <div class="col-md-5 col-sm-5 col-xs-12 no-spacing">
              <img src="{{url('img/ic-file.png')}}" class="thumbnail preview"/>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12 no-spacing v-spacing spacing-md">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-file-text"></i></span>
                <input id="judul" name="judul" type="text" class="form-control" placeholder="Judul Arsip" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1" value="{{$arsip->judul}}">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-edit"></i></span>
                <input id="no_arsip" name="no_arsip" type="text" maxlength="18" class="form-control" placeholder="Nomor Arsip" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="2" value="{{$arsip->no_arsip}}">
              </div>
              <div class="input-group date" data-provide="datepicker">
                  <div class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                  </div>
                  <input id="jra" name="jra" type="text" class="form-control" placeholder="Jadwal Retensi Arsip" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="3" value="{{date('d/m/Y', strtotime($arsip->jadwal_retensi))}}">
              </div>
            </div>
          </div>
          <hr/>
          <div class="container-fluid no-spacing">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open"></i></span>
              <select id="root" name="root" class="form-control" aria-describedby="basic-addon1" tabindex="4" required data-parsley-errors-messages-disabled>
                <option value="">Kategori Arsip</option>
                @foreach($direktori as $direktori)
                  @if($direktori->id_direktori == $root)
                    <option value="{{$direktori->id_direktori}}" selected="selected">{{$direktori->nama_direktori}}</option>
                  @else
                    <option value="{{$direktori->id_direktori}}">{{$direktori->nama_direktori}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <textarea id="deskripsi" name="deskripsi" class="form-control custom-control" rows="5" style="resize:none" placeholder="Deskripsi arsip ..." tabindex="3">{{$arsip->deskripsi}}</textarea>
            </div>
            <div class="container-fluid no-spacing">
              <div class="col-md-7 no-spacing">
                <div class="input-group">
                    <input id="filelabel" name="filelabel" type="text" class="form-control" readonly value="{{$arsip->file}}">
                    <label class="input-group-btn">
                        <span class="btn btn-default" tabindex="4">
                            Pilih File <input id="dokumen" name="dokumen" type="file" style="display: none;">
                        </span>
                    </label>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="hidden" name="direktori" value="{{$arsip->id_direktori}}"/>
              <div class="col-md-5 no-spacing">
                  <div class="input-group pull-right">
                    <button class="btn btn-default add pull-right" type="submit" tabindex="8"><i class="fa fa-check"></i> Simpan</a>
                  </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Riwayat Arsip
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-hover data-table">
                  <thead>
                    <th>
                      <td></td>
                      <td class="th-md"></td>
                    </th>
                  </thead>
                  <tbody>
                    @foreach($log as $log)
                    <tr>
                      <td>
                        <img src="{{url($log->foto)}}" class="avatar-xs" alt="{{$log->deskripsi}}">
                      </td>
                      <td>
                        {{$log->deskripsi}}
                        <p class="no-spacing"><i class="fa fa-calendar"></i> {{date('d/M/Y', strtotime($log->created_at))}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($log->created_at))}}</p>
                      </td>
                      <td><i class="fa fa-clock-o"></i> {{Carbon::parse($log->created_at)->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
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
        // {
        //   extend: "pdf",
        //   className: "btn-sm"
        // },
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
    //$('#dokumensiklus').find("table").dataTable();
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

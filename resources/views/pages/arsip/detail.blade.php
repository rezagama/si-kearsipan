@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Daftar Arsip / '. $arsip->judul)

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
  <li><a class="active" href="{{URL::route('arsip.detail', $arsip->id_arsip)}}">{{$arsip->judul}}</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Detail Arsip <a href="{{URL::route('arsip.edit', $arsip->id_arsip)}}" class="btn btn-warning btn-sm btn-panel-heading pull-right"><i class="fa fa-edit"></i></a>
      </div>
      <div class="panel-body">
        <div class="container-fluid no-spacing">
          <div class="col-md-5 col-sm-5 col-xs-12 no-spacing">
            <img src="{{url('img/ic-file.png')}}" class="thumbnail preview"/>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-12 no-spacing">
            <label>Judul</label>
            <p>{{$arsip->judul}}</p>
            <label>No. Arsip</label>
            <p>{{$arsip->no_arsip}}</p>
            <label>Jadwal Retensi</label>
            <p>{{date('D, d M Y', strtotime($arsip->jadwal_retensi))}}</p>
          </div>
        </div>
        <hr/>
        <div class="container-fluid no-spacing">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Pencipta Arsip</label>
            <p>
              <a href="{{URL::route('account.show', $arsip->id_user)}}">{{$arsip->nama}}</a>
            </p>
            <label>Folder</label>
            <p>{{$arsip->nama_kategori}}</p>
            <label>Ditambahkan Pada</label>
            <p>{{date('D, d M Y', strtotime($arsip->created_at))}}</p>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Deskripsi</label>
            <p>
              @if($arsip->deskripsi == '')
                -
              @else
                {{$arsip->deskripsi}}
              @endif
            </p>
            <label>Kategori Arsip</label>
            <p>
              @if($arsip->status == 0)
                <span class="label label-danger inline">Arsip Dimusnahkan</span>
              @elseif($arsip->status == 1)
                <span class="label label-success inline">Arsip Aktif</span>
              @elseif($arsip->status == 2)
                <span class="label label-primary inline">Arsip Inaktif</span>
              @elseif($arsip->status == 3)
                <span class="label label-info inline">Arsip Statis</span>
              @else
                <span class="label label-warning inline">Arsip Lain-lain</span>
              @endif
            </p>
          </div>
          <div class="col-md-12">
            <a href="{{URL::route('arsip.download', $arsip->id_arsip)}}" class="btn btn-primary btn-print" target="_blank"><i class="fa fa-print"></i> Print Arsip</a>
          </div>
        </div>
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
                      <td class="th-md"></td>
                      <td></td>
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
<script src="{{asset('js/script.js')}}"></script>
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
@endsection

@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / Pengumuman')

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  <li><a class="active" href="{{URL::route('pengumuman.index')}}">Pengumuman</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Menu
      </div>
      <div class="list-group">
        <a href="{{URL::route('pengumuman.index')}}" class="list-group-item active"><i class="fa fa-list"></i> Daftar Pengumuman</a>
        <a href="{{URL::route('pengumuman.compose')}}" class="list-group-item"><i class="fa fa-pencil"></i> Tulis Pengumuman</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                Daftar Pengumuman
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-hover data-table">
                  <thead>
                    <tr>
                      <td class="table-lg"></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pengumuman as $pengumuman)
                    <tr>
                      <td>
                        <p class="no-spacing"><a href="{{URL::route('pengumuman.show', $pengumuman->id_pengumuman)}}" class="font-brown-bold">{{$pengumuman->judul_pengumuman}}</a></p>
                        <p class="no-spacing"><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($pengumuman->created_at, 'l, d M Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($pengumuman->created_at))}} <i class="fa fa-user"></i> <a class="font-brown" href="{{URL::route('account.show', $pengumuman->id_user)}}">{{$pengumuman->nama}}</a></p>
                        <p align="justify">{!! Helpers::trimText($pengumuman->isi_pengumuman, 30) !!}</p>
                        <p align="right"><i class="fa fa-clock-o"></i> {{Carbon::parse($pengumuman->created_at)->diffForHumans()}}</p>
                      </td>
                      <td align="center">
                        <form action="{{URL::route('pengumuman.delete', $pengumuman->id_pengumuman)}}" class="inline" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus pengumuman ini?');">
                          <input type="hidden" name="_method" value="DELETE"></input>
                          <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                          <button type="submit" class="btn btn-danger btn-sm btn-sm-spacing"><i class="fa fa-trash"></i></button>
                        </form>
                        <a href="{{URL::route('pengumuman.edit', $pengumuman->id_pengumuman)}}" type="button" class="btn btn-info btn-sm btn-sm-spacing"><i class="fa fa-pencil"></i></a>
                        <a href="{{URL::route('pengumuman.show', $pengumuman->id_pengumuman)}}" type="button" class="btn btn-success btn-sm btn-sm-spacing"><i class="fa fa-chevron-right"></i></a>
                      </td>
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
        "oLanguage": {
          "sEmptyTable": "Belum ada pengumuman."
        },
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

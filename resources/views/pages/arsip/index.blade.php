@extends('layouts.main')

@section('title', $title)

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if(isset($path))
  <li><a href="{{URL::route('arsip.index')}}">Daftar Arsip</a></li>
    @for ($i = $size; $i >= 0; $i--)
      @if($i == 0)
        <li><a href="{{$path[$i]['url']}}" class="active">{{$path[$i]['title']}}</a></li>
      @else
        <li><a href="{{$path[$i]['url']}}">{{$path[$i]['title']}}</a></li>
      @endif
    @endfor
  @else
    <li><a class="active" href="{{URL::route('arsip.index')}}">Daftar Arsip</a></li>
  @endif
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Kelola Kategori
      </div>
      <form id="form" action="{{URL::route('kategori.store')}}" method="POST" enctype="multipart/form-data">
        <div class="panel-body">
          <div class="container-fluid no-spacing">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open"></i></span>
              <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Kategori" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
              <input id="parent" name="parent" value="{{$id}}" type="hidden"/>
            </div>
            <div class="input-group pull-right">
              <button class="btn btn-default btn-sm add" type="submit" tabindex="8"><i class="fa fa-plus"></i> Tambahkan Kategori</a>
            </div>
          </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
      </form>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        {{$panel}}
      </div>
      <div class="panel-body">
        <div class="row list-group">
          @if($count > 0)
            @foreach ($arsip as $arsip)
            <div class="item col-xs-4 col-lg-2 col-md-2">
                <div class="thumbnail folder">
                    <a href="{{URL::route('arsip.dokumen', $arsip->id_kategori)}}" class="btn btn-success btn-sm btn-folder"><i class="fa fa-list"></i></a>
                    <img class="group list-group-image" src="{{url('img/folder.png')}}" alt="{{$arsip->nama_kategori}}" />
                    <div class="kategori">
                        <a href="{{URL::route('arsip.show', $arsip->id_kategori)}}">{{$arsip->nama_kategori}}</a>
                    </div>
                </div>
            </div>
            @endforeach
          @else
            <p align="center">Belum ada folder di kategori {{$panel}}</p>
          @endif
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

@extends('layouts.main')

@section('title', $title)

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if(isset($path))
  <li><a href="{{URL::route('kategori.index')}}">Kategori Arsip</a></li>
    @for ($i = $size; $i >= 0; $i--)
      @if($i == 0)
        <li><a href="{{$path[$i]['url']}}" class="active">{{$path[$i]['title']}}</a></li>
      @else
        <li><a href="{{$path[$i]['url']}}">{{$path[$i]['title']}}</a></li>
      @endif
    @endfor
  @else
    <li><a class="active" href="{{URL::route('kategori.index')}}">Kategori Arsip</a></li>
  @endif
</ol>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editLabel">Edit</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open"></i></span>
          <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Kategori" aria-describedby="basic-addon1" required data-parsley-errors-messages-disabled tabindex="1">
        </div>
      </div>
      <div class="modal-footer">
        <form id="delete" action="{{URL::route('kategori.hapus')}}" class="inline" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus folder ini? Semua arsip dalam folder ini akan hilang.');">
          <input type="hidden" name="_method" value="DELETE"></input>
          <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
          <input type="hidden" name="id" id="id"></input>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
        </form>
        <form action="{{URL::route('kategori.update')}}" class="inline update" method="POST">
          <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
          <input type="hidden" name="id" id="id"></input>
          <input type="hidden" name="kategori" id="kategori"</input>
          <input type="hidden" name="parent" id="parent" value="{{$id}}"></input>
          <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
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
            @foreach ($kategori as $kategori)
            <div class="item col-xs-4 col-lg-2 col-md-2">
                <div class="thumbnail folder">
                    @if($kategori->level_kategori != 1)
                      <a data-toggle="modal" href="#edit" data-id="{{$kategori->id_kategori}}" data-title="{{$kategori->nama_kategori}}" data-level="{{$kategori->level_kategori}}" class="btn btn-primary btn-sm btn-folder"><i class="fa fa-edit"></i></a>
                    @endif
                    <img class="group list-group-image" src="{{url('img/folder.png')}}" alt="{{$kategori->nama_kategori}}" />
                    <div class="kategori">
                        <a href="{{URL::route('kategori.show', $kategori->id_kategori)}}">{{$kategori->nama_kategori}}</a>
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
<script src="{{asset('js/arsip/edit.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
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

<script type="text/javascript">
  $('#form').parsley();
</script>
@endsection

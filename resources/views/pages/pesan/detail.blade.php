@extends('layouts.main')

@section('title', 'Sistem Informasi Kearsipan / '.$pesan->judul_pesan)

@section('css')
  <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection

@section('content')
<ol class="breadcrumb v-spacing">
  <i class="fa fa-sitemap breadcrumb-ic"></i> <li><a href="{{URL::route('dashboard.index')}}">Dashboard</a></li>
  @if($title == 'Pesan Masuk')
    <li><a href="{{URL::route('pesan.masuk')}}">{{$title}}</a></li>
  @else
    <li><a href="{{URL::route('pesan.keluar')}}">{{$title}}</a></li>
  @endif
  <li><a class="active" href="{{URL::route('pesan.show', $pesan->id_pesan)}}">{{$pesan->judul_pesan}}</a></li>
</ol>
<div class="row v-spacing">
  <div class="col-sm-6 col-md-3 col-xs-12">
    <div class="panel panel-default sidebar-stat">
      <div class="panel-heading">
        @if($title == 'Pesan Masuk')
          Dikirim oleh
        @else
          Dikirim kepada
        @endif
      </div>
      <div class="panel-body v-spacing">
        <div class="msg-avatar">
    			<img src="{{url($user->foto)}}" class="img-responsive thumbnail" alt="{{$user->nama}}">
    		</div>
    		<div class="user-info msg">
    			<div class="username">
    				<a class="font-brown" target="_blank" href="{{URL::route('account.show', $user->id_user)}}">{{$user->nama}}</a>
            @if($user->level == 0)
              <span class="label label-success font-xs">Admin</span>
            @else
              <span class="label label-info font-xs">Staff</span>
            @endif
    			</div>
          <div class="title">
    				{{$user->nip}}
    			</div>
    		</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-9 col-xs-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                {{$pesan->judul_pesan}}
        </div>
        <div class="panel-body">
            <div class="tab-content">
              <table class="table table-condensed data-table">
                  <thead>
                    <tr>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody class="border-top-gray">
                    @foreach($isi_pesan as $isi_pesan)
                    <tr class="v-spacing">
                      @if($isi_pesan->id_user == Auth::user()->id_user)
                      <td class="no-border">
                        <img src="{{url($isi_pesan->foto)}}" class="avatar-msg inline right-margin-sm" alt="{{$isi_pesan->nama}}">
                        <div class="pesan inline">
                          <div class="container-fluid no-spacing">
                            <div class="pull-left">
                              <a class="font-brown-bold" href="{{URL::route('account.show', $pesan->id_user)}}">{{$isi_pesan->nama}} </a>
                            </div>
                            @if($isi_pesan->id_user == Auth::user()->id_user)
                            <div class="pull-right">
                              <a href="{{URL::route('pesan.edit', $isi_pesan->id_isi_pesan)}}" class="font-brown"><i class="fa fa-pencil"></i> Edit</a>
                            </div>
                            @endif
                          </div>
                          <p align="justify" class="vertical-spacing-sm">{!! $isi_pesan->balasan !!}</p>
                          <div class="container-fluid fit-width no-padding vertical-spacing-sm">
                            <div class="col-md-6 no-padding" align="left">
                              <i class="fa fa-calendar"></i> {{Carbon::parse($isi_pesan->created_at)->formatLocalized('%d, %B %Y')}}
                              <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($isi_pesan->created_at))}}
                            </div>
                            <div class="col-md-6 no-padding vertical-spacing-xs" align="right">
                              @if($isi_pesan->status == 0 || $isi_pesan->status == 3)
                                <p class="font-sm font-grey">
                                  {{Carbon::parse($isi_pesan->updated_at)->diffForHumans()}}
                                  @if($isi_pesan->status == 3) <span class="label label-primary">Telah Dirubah</span> @endif
                                  <span class="label label-success">Terkirim</span>
                                </p>
                              @else
                                <p class="font-sm font-grey">
                                  {{Carbon::parse($isi_pesan->updated_at)->diffForHumans()}}
                                  @if($isi_pesan->status == 4) <span class="label label-primary">Telah Dirubah</span> @endif
                                  <span class="label label-info">Dibaca</span></p>
                              @endif
                            </div>
                          </div>
                        </div>
                      </td>
                      @else
                      <td class="no-border">
                        <div class="pull-right">
                          <div class="pesan inline">
                            <div class="container-fluid no-spacing">
                              <div class="pull-right">
                                <a class="font-brown-bold" href="{{URL::route('account.show', $pesan->id_user)}}"> {{$isi_pesan->nama}} </a>
                              </div>
                              @if($isi_pesan->id_user == Auth::user()->id_user)
                              <div class="pull-left">
                                <a href="{{URL::route('pesan.edit', $isi_pesan->id_isi_pesan)}}" class="font-brown"><i class="fa fa-pencil"></i> Edit</a>
                              </div>
                              @endif
                            </div>
                            <div class="container-fluid pull-right vertical-spacing-sm no-padding">
                                <p align="justify" class="no-spacing">{!! $isi_pesan->balasan !!}</p>
                            </div>
                            <div class="container-fluid fit-width no-padding vertical-spacing-sm">
                              <div class="col-md-6 no-padding vertical-spacing-sm" align="left">
                                @if($isi_pesan->status == 0 || $isi_pesan->status == 3)
                                  <p class="pull-left font-sm font-grey">
                                    {{Carbon::parse($isi_pesan->updated_at)->diffForHumans()}}
                                    @if($isi_pesan->status == 3) <span class="label label-primary">Telah Dirubah</span> @endif
                                    <span class="label label-success">Terkirim</span>
                                  </p>
                                @else
                                  <p class="pull-left font-sm font-grey">
                                    {{Carbon::parse($isi_pesan->updated_at)->diffForHumans()}}
                                    @if($isi_pesan->status == 4) <span class="label label-primary">Telah Dirubah</span> @endif
                                    <span class="label label-info">Dibaca</span></p>
                                @endif
                              </div>
                              <div class="col-md-6 no-padding" align="right">
                                <i class="fa fa-calendar"></i> {{Carbon::parse($isi_pesan->created_at)->formatLocalized('%d, %B %Y')}}
                                <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($isi_pesan->created_at))}}
                              </div>
                            </div>
                          </div>
                          <img src="{{url($isi_pesan->foto)}}" class="avatar-msg inline left-margin-sm" alt="{{$isi_pesan->nama}}">
                        </div>
                      </td>
                      @endif
                    </tr>
                    @endforeach
                    <tr>
                      <td>
                        <form id="form" class="form" action="{{URL::route('pesan.balas', $pesan->id_pesan)}}" method="POST" enctype="multipart/form-data">
                          <input name="_token" type="hidden" value="{{csrf_token()}}"/>
                          <div id="reply-field">
                          </div>
                          <textarea id="balasan" name="balasan" style="display: none;" required data-parsley-errors-messages-disabled></textarea>
                          <button type="submit "class="btn btn-default pull-right vertical-spacing-sm"> <i class="fa fa-paper-plane"></i> Kirim</button>
                        </form>
                      </td>
                    </tr>
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
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/pesan/msg.js')}}"></script>
<script src="{{asset('js/parsley.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<!-- Datatables-->

<script>
  var handleDataTableButtons = function() {
      "use strict";
      0 !== $(".data-table").length && $(".data-table").DataTable({
        "ordering": false,
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

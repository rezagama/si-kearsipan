<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Informasi Kearsipan / Pengumuman</title>

        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{url('css/style.css')}}">
        <link rel="stylesheet" href="{{url('css/login.css')}}">
        <link rel="shortcut icon" href="{{url('favicon.ico')}}">
    </head>
    <body>
        <div class="top-content">
            <div class="inner-bg">
                <div class="container" align="left">
                  <ol class="breadcrumb v-spacing">
                    <i class="fa fa-sitemap breadcrumb-ic"></i>
                    <li><a href="{{URL::route('login.index')}}">Beranda</a></li>
                    <li><a class="active" href="{{URL::route('pengumuman.list')}}">Pengumuman</a></li>
                  </ol>
                  <div class="row v-spacing">
                    <div class="col-sm-6 col-md-3 col-xs-12">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          Menu
                        </div>
                        <div class="list-group">
                          <a href="{{URL::route('login.index')}}" class="list-group-item"><i class="fa fa-home"></i> Beranda</a>
                          <a href="{{URL::route('pengumuman.list')}}" class="list-group-item active bg-blue-gray"><i class="fa fa-newspaper-o"></i> Pengumuman</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-9 col-xs-12">
                      <div class="panel with-nav-tabs panel-default">
                          <div class="panel-heading">
                            Pengumuman
                          </div>
                          <div class="panel-body">
                              <div class="tab-content">
                                <table class="table table-hover data-table">
                                    <thead>
                                      <tr>
                                        <td></td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($pengumuman as $pengumuman)
                                      <tr>
                                        <td>
                                          <p class="no-spacing"><a href="{{URL::route('pengumuman.post', $pengumuman->id_pengumuman)}}" class="font-brown-bold">{{$pengumuman->judul_pengumuman}}</a></p>
                                          <p class="no-spacing font-black"><i class="fa fa-calendar"></i> {{Helpers::formatLocalDate($pengumuman->created_at, 'l, d M Y')}} <i class="fa fa-clock-o"></i> {{date('H:i', strtotime($pengumuman->created_at))}} <i class="fa fa-user"></i> <a class="font-brown" href="{{URL::route('account.show', $pengumuman->id_user)}}">{{$pengumuman->nama}}</a></p>
                                          <div align="justify" class="font-black vertical-spacing-sm">{!! Helpers::trimText($pengumuman->isi_pengumuman, 30) !!}</div>
                                          <p align="right"><i class="fa fa-clock-o"></i> {{Carbon::parse($pengumuman->created_at)->diffForHumans()}}</p>
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
                </div>
            </div>
        </div>
        <script src="{{url('js/jquery-1.12.3.min.js')}}"></script>
        <script src="{{url('js/bootstrap.min.js')}}"></script>
    </body>
</html>

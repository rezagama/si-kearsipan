<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Informasi Kearsipan</title>

        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{url('css/login.css')}}">
        <link rel="shortcut icon" href="{{url('favicon.ico')}}">
    </head>
    <body>
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2 text">
                              <h1>Selamat Datang di Sistem Informasi Kearsipan</h1>
                              <h1>Daerah Istimewa Yogyakarta</h1>
                        </div>
                    </div>
                    <div class="row form-box">
                      @if(Session::has('error'))
                      <div class="alert alert-warning fade in alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          {{Session::get('error')}}
                      </div>
                      @endif
                      @if(Session::has('info'))
                      <div class="alert alert-info fade in alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          {{Session::get('info')}}
                      </div>
                      @endif
                      <div class="col-sm-8">
                        <div id="carousel" class="carousel slide pengumuman" data-ride="carousel">
                          <ol class="carousel-indicators">
                            @for($i=0;$i<$jumlah_pengumuman;$i++)
                              @if($i == 0)
                                <li data-target="#carousel" data-slide-to="{{$i}}" class="active"></li>
                              @else
                                <li data-target="#carousel" data-slide-to="{{$i}}"></li>
                              @endif
                            @endfor
                          </ol>
                          <div class="carousel-inner" role="listbox">
                            @foreach($pengumuman as $key => $pengumuman)
                              @if($key == 0)
                              <div class="item active">
                                <img src="{{url('img/background-pengumuman.jpg')}}" alt="pengumuman">
                                <span class="text-pengumuman">
                                  <p class="judul-pengumuman no-spacing"><a href="{{URL::route('pengumuman.post', $pengumuman->id_pengumuman)}}" class="font-yellow cursor-pointer">{{$pengumuman->judul_pengumuman}}</a></p>
                                  <div class="deskripsi-pengumuman">{!! Helpers::trimText($pengumuman->isi_pengumuman, 25) !!}</div>
                                </span>
                                <span class="transparent-bg"/>
                              </div>
                              @else
                              <div class="item">
                                <img src="{{url('img/background-pengumuman.jpg')}}" alt="pengumuman">
                                <span class="text-pengumuman">
                                  <p class="judul-pengumuman no-spacing"><a href="{{URL::route('pengumuman.post', $pengumuman->id_pengumuman)}}" class="font-yellow cursor-pointer">{{$pengumuman->judul_pengumuman}}</a></p>
                                  <div class="deskripsi-pengumuman">{!! Helpers::trimText($pengumuman->isi_pengumuman, 25) !!}</div>
                                </span>
                                <span class="transparent-bg"/>
                              </div>
                              @endif
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-top">
                          <div class="form-top-left">
                            <h3>Login</h3>
                              <p>Masukkan NIP dan Password untuk masuk ke dalam Sistem Informasi Kearsipan :</p>
                          </div>
                        </div>
                        <div class="form-bottom">
                          <form id="form" action="{{URL::route('user.login')}}" method="POST" class="login-form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                              <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="nip" placeholder="NIP" class="form-username form-control" id="form-username">
                              </div>
                              <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="password" placeholder="Password" class="form-password form-control" id="form-password">
                              </div>
                              <button type="submit" class="btn">Login</button>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{url('js/jquery-1.12.3.min.js')}}"></script>
        <script src="{{url('js/bootstrap.min.js')}}"></script>
        <script src="{{url('js/login.js')}}"></script>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Informasi Kearsipan</title>

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
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
                      <div class="col-sm-8">
                        <div id="carousel" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                            <li data-target="#carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel" data-slide-to="1"></li>
                          </ol>
                          <div class="carousel-inner" role="listbox">
                            <div class="item active">
                              <img src="{{url('img/tugu_jogja.png')}}" alt="Jogja">
                            </div>

                            <div class="item">
                              <img src="{{url('img/bank_indonesia.jpg')}}" alt="BI">
                            </div>
                          </div>
                          <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
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
                          <form role="form" action="" method="post" class="login-form">
                            <div class="form-group">
                              <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username">
                              </div>
                              <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
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

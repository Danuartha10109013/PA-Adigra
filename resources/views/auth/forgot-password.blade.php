<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Absensi @yield('title')</title>

    {{-- icon web --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bpsdm.png') }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/adminlte/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="text-center">
                <img src="{{asset('images/tekmt.png')}}" class="img-fluid rounded mt-4" alt="" style="height: 100px; width: 180px">
            </div>
            <div class="card-body login-card-body">
                <h3 class="text-center">
                    <b>-- Lupa Password --</b>
                </h3>
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Gagal </strong>{{ session('error') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Berhasil </strong>{{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
                <p class="login-box-msg">
                    Anda lupa password anda? Di sini anda dapat dengan mudah mengambil password baru.</p>
                <form action="/forgot-password" method="POST">
                    {{ csrf_field() }}
                    @method('POST')
                    @if($errors->has('email'))
                        <span class="help-block text-danger mb-4">{{ $errors->first('email') }}</span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                        placeholder="Email" value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" style="color: aliceblue">
                                <i class="fa fa-paper-plane"></i> <b>Meminta password baru</b>     
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-center mt-2 ">
                            <div class=" text-right" >
                                <a href="/" > <i class="fa fa-sign-in-alt"></i> Masuk</a>
                            </div>
                            {{-- <div class="d-flex justify-content-between">
                                <a href="/login" class="btn btn-outline-primary btn-block m-1"> <i class="fa fa-arrow-right"></i> Masuk</a>
                            </div> --}}
                            {{-- <div>
                                Belum punya akun? <a href="/daftar" class=""> <b>Daftar</b> </a>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

        <!-- jQuery -->
        <script src="{{asset('assets/adminlte/plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('assets/adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)

        </script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('assets/adminlte/dist/js/adminlte.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{asset('assets/adminlte/dist/js/pages/dashboard.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset('assets/adminlte/dist/js/demo.js')}}"></script>
        <!-- DataTables -->
        <script src="{{asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}">
        </script>
        <script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}">
        </script>

</body>

</html>

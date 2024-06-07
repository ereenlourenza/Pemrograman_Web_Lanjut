<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Sinar Indo | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <script>
    function readURL(input){
      if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function (e){
          $('#Image1')
          .attr('src', e.target.result)
          .width(70)
          .height(70);
        };
        reader.readAsDataURL(input.files[0])
      }
    }
  </script>
  <style>
    input[type=profile_img]{
      color:transparent;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="{{ route('register.index') }}"><b>Toko Sinar Indo</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form action="{{ route('register.storeMember') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3" style="justify-content: center">
          <img id="Image1" src="{{ asset('logo/Default.png') }}" class="img-circle" style="width: 70px; height: 70px; opacity: 70%"/>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="nama" value="{{old('nama')}}" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" value="{{old('username')}}" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <div class="input-group mb-3">
          <input type="file" class="form-control" placeholder="Gambar Profil" id="profile_img" name="profile_img" onchange="readURL(this);" accept=".jpg,.jpeg,.png">
          {{-- <input type="file" style="visibility:hidden" class="form-control" id="profile_img" name="profile_img" onchange="readURL(this);" accept="image/.jpg.png.jpeg"/> --}}
          {{-- <button id="files" style="display:block;width:110px; height:30px;" onclick="document.getElementById('profile_img').click(); return false;">Upload Photo</button>   --}}
          <div class="input-group-append">
            <div class="input-group-text">
              <small class="form-text text-muted">Image : (jpg/jpeg/png)</small>
            </div>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-file-image"></span>
            </div>
          </div>            
        </div>
          
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4 mx-auto">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-0 mt-3">
        <a href="{{ route('login.index') }}" class="text-center">I already have a membership</a>
      </p>
      </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>

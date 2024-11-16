<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="position: sticky; top: 0px;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"><b>{{ auth()->user()->name }}</b></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" style="border-left: 3px solid #0d6efd">
          <i class="fa fa-user"></i> {{ Str::of(auth()->user()->name)->explode(' ')->map(fn ($name) => $name[0])->join('') }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Pengaturan</span>
          <div class="dropdown-divider"></div>
          <a href="/backoffice/user-data/user/{{ auth()->user()->id }}/profile" class="dropdown-item">
            <i class="fas fa-circle-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          
          <a href="/logout" class=" btn btn-block btn-danger"><i class="fas fa-sign-out-alt"></i> Keluar</a>
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->
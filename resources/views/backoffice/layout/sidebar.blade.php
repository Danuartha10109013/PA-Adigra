<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/backoffice/dashboard" class="brand-link">
        <img src="{{ asset('images/tekmt.png') }}"
                alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: .8">
        <span class="brand-text" style="text-transform: uppercase">
            <b>Absensi</b>
        </span>
        {{-- <div class="d-flex "> --}}
            {{-- <div>
                <img src="{{ asset('images/absen-logo.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8; width: 100%">
            </div> --}}
            {{-- <div class="ml-2">
                <span class="brand-text" style="text-transform: uppercase"> <b>Absensi</b> </span>
            </div> --}}
        {{-- </div> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 mb-3 text-center">

            <div class="info">
                <p style="text-transform: uppercase">
                    <b>{{ auth()->user()->role->name }}</b>
                </p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                
                @if (auth()->user()->role_id == 1)
                
                    <li class="nav-item">
                        <a href="/backoffice/dashboard"
                            class="nav-link {{ request()->is('backoffice/dashboard', 'backoffice/dashboard/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/backoffice/office"
                            class="nav-link {{ request()->is('backoffice/office', 'backoffice/office/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-building"></i>
                            <p>
                                Kantor
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="/backoffice/shift"
                            class="nav-link {{ request()->is('backoffice/shift', 'backoffice/shift/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-clock"></i>
                            <p>
                                Shift
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/backoffice/absent"
                            class="nav-link {{ request()->is('backoffice/absent', 'backoffice/absent/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                Absensi
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('backoffice/user-data/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('backoffice/user-data/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-user"></i>
                            <p>
                                Data Pengguna
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/backoffice/user-data/role"
                                    class="nav-link {{ request()->is('backoffice/user-data/role', 'backoffice/user-data/role/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Peran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backoffice/user-data/user"
                                    class="nav-link {{ request()->is('backoffice/user-data/user', 'backoffice/user-data/user/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Pengguna</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- <li class="nav-item has-treeview {{ request()->is('backoffice/master-data/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('backoffice/master-data/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-landmark"></i>
                            <p>
                                Data Master
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/backoffice/master-data/division"
                                    class="nav-link {{ request()->is('backoffice/master-data/division', 'backoffice/master-data/division/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Divisi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backoffice/master-data/position"
                                    class="nav-link {{ request()->is('backoffice/master-data/position', 'backoffice/master-data/position/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Jabatan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backoffice/master-data/shift"
                                    class="nav-link {{ request()->is('backoffice/master-data/shift', 'backoffice/master-data/shift/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Shift</p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    
                @endif

                @if (auth()->user()->role_id == 2)
                    <li class="nav-item">
                        <a href="/backoffice/absen/create"
                            class="nav-link {{ request()->is('backoffice/absen/create') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-file-signature"></i>
                            <p>
                                Absen
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/backoffice/absent/self"
                            class="nav-link {{ request()->is('backoffice/absent/self', 'backoffice/absent/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-tasks"></i>
                            <p>
                                Absensi Saya
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item has-treeview {{ request()->is('backoffice/submission/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('backoffice/submission/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Pengajuan Absensi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/backoffice/submission/cuti"
                                class="nav-link {{ request()->is('backoffice/submission/cuti', 'backoffice/submission/cuti/*') ? 'active' : '' }}">
                                <i class="fa fa-circle fa-regular nav-icon"></i>
                                <p>Cuti</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/backoffice/submission/izin-sakit"
                                class="nav-link {{ request()->is('backoffice/submission/izin-sakit', 'backoffice/submission/izin-sakit/*') ? 'active' : '' }}">
                                <i class="fa fa-circle fa-regular nav-icon"></i>
                                <p>Izin / Sakit</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/backoffice/task"
                        class="nav-link {{ request()->is('backoffice/task') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-edit"></i>
                        <p>
                            Task Tugas
                        </p>
                    </a>
                </li>

                {{-- @if (auth()->user()->role_id == 2)
                    <li class="nav-item has-treeview {{ request()->is('backoffice/task/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('backoffice/task/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Projek dan Tugas
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/backoffice/task/task-project"
                                    class="nav-link {{ request()->is('backoffice/task/task-project', 'backoffice/task/task-project/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Task Project</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backoffice/task/task-maintenance"
                                    class="nav-link {{ request()->is('backoffice/task/task-maintenance', 'backoffice/task/task-maintenance/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Task Maintenance</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif --}}

            </ul>
        </nav>
        
    </div>
    
</aside>

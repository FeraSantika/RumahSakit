<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="{{ route('admin.home') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index-2.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-dark.png') }} " alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" height="42"
                    class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    {{-- <span class="badge bg-success float-end">5</span> --}}
                    <span> Master User </span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'role' ? 'active' : '' }}"
                                href="{{ route('role') }}">Role</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'user' ? 'active' : '' }}"
                                href="{{ route('user') }}">User</a>
                        </li>
                        {{-- <li>
                            <a class="nav-link" href="">Dokter</a>
                        </li>
                        <li>
                            <a class="nav-link" href="">Apoteker</a>
                        </li>
                        <li>
                            <a class="nav-link" href="">Resepsionis</a>
                        </li>
                        <li>
                            <a class="nav-link" href="">Kasir</a>
                        </li> --}}
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'pasien' ? 'active' : '' }}" href="{{route('pasien')}}">Pasien</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMenu" aria-expanded="false" aria-controls="sidebarDashboards"
                    class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Master Menu </span>
                </a>
                <div class="collapse" id="sidebarMenu">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'menu' ? 'active' : '' }}"
                                href="{{ route('menu') }}">Menu</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{route('poli')}}"
                    class="side-nav-link {{ Route::current()->getName() == 'poli' ? 'active' : '' }}">
                    <i class="ri-file-add-line"></i>
                    <span> Poli </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('akses-poli')}}"
                    class="side-nav-link">
                    <i class="ri-file-user-line"></i>
                    <span> Akses Poli </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('daftar.online')}}"
                    class="side-nav-link">
                    <i class="ri-calendar-event-line"></i>
                    <span> Daftar Online </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('list-daftar-pasien')}}"
                    class="side-nav-link">
                    <i class="uil-clipboard-notes"></i>
                    <span> List Daftar Pasien</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('kategori')}}"
                    class="side-nav-link">
                    <i class=" uil-tablets"></i>
                    <span>Kategori Obat</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('obat')}}"
                    class="side-nav-link">
                    <i class=" uil-capsule"></i>
                    <span> Obat</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{route('tindakan')}}"
                    class="side-nav-link">
                    <i class=" uil-syringe"></i>
                    <span> Master Tindakan</span>
                </a>
            </li>

            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTransaksi" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-shopping-trolley"></i>
                    <span> Transaksi </span>
                </a>
                <div class="collapse" id="sidebarTransaksi">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'transaksi.bk' ? 'active' : '' }}"
                                href="{{ route('transaksi.bk') }}">Transaksi Barang Keluar</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'transaksi.bm' ? 'active' : '' }}""
                                href="{{route('transaksi.bm')}}">Transaksi Barang Masuk</a>
                        </li>
                    </ul>
                </div>
            </li> --}}

            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLaporan" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-clipboard-blank"></i>
                    <span> Laporan </span>
                </a>
                <div class="collapse" id="sidebarLaporan">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan.tbk' ? 'active' : '' }}"
                                href="{{ route('laporan.tbk') }}">Laporan Transaksi Keluar</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan.tbm' ? 'active' : '' }}""
                                href="{{route('laporan.tbm')}}">Laporan Transaksi Masuk</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan.bk' ? 'active' : '' }}""
                                href="{{route('laporan.bk')}}">Laporan Barang Keluar</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan.bm' ? 'active' : '' }}""
                                href="{{route('laporan.bm')}}">Laporan Barang Masuk</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
        </ul>
        <!--- End Sidemenu -->
        <div class="clearfix"></div>
    </div>
</div>

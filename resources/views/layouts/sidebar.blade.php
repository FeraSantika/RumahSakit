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
                            <a class="nav-link {{ Route::current()->getName() == 'pasien' ? 'active' : '' }}"
                                href="{{ route('pasien') }}">Pasien</a>
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
                <a data-bs-toggle="collapse" href="#sidebarPoli" aria-expanded="false" aria-controls="sidebarDashboards"
                    class="side-nav-link">
                    <i class="ri-file-add-line"></i>
                    <span> Master Poli </span>
                </a>
                <div class="collapse" id="sidebarPoli">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'poli' ? 'active' : '' }}"
                                href="{{ route('poli') }}">Poli</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'akses-poli' ? 'active' : '' }}"
                                href="{{ route('akses-poli') }}">Akses Poli</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDaftar" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="ri-calendar-event-line"></i>
                    <span> Pendaftaran Pasien </span>
                </a>
                <div class="collapse" id="sidebarDaftar">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'daftar.online' ? 'active' : '' }}"
                                href="{{ route('daftar.online') }}">Pendaftaran Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'daftar.pasieninap' ? 'active' : '' }}"
                                href="{{ route('daftar.pasieninap') }}">Pendaftaran Rawat Inap</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarListpasien" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-clipboard-notes"></i>
                    <span> List Daftar Pasien </span>
                </a>
                <div class="collapse" id="sidebarListpasien">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'list-daftar-pasien' ? 'active' : '' }}"
                                href="{{ route('list-daftar-pasien') }}">Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'list-daftar-pasienInap' ? 'active' : '' }}"
                                href="{{route('list-daftar-pasienInap')}}">Rawat Inap</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('tindakan') }}" class="side-nav-link">
                    <i class=" uil-syringe"></i>
                    <span> Master Tindakan</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarObat" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-tablets"></i>
                    <span> Master Obat </span>
                </a>
                <div class="collapse" id="sidebarObat">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'kategori' ? 'active' : '' }}"
                                href="{{ route('kategori') }}">Kategori Obat</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'obat' ? 'active' : '' }}"
                                href="{{ route('obat') }}">Obat</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('transaksi-obat') }}" class="side-nav-link">
                    <i class="uil-money-bill"></i>
                    <span> Transaksi Obat</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('transaksi-pembayaran') }}" class="side-nav-link">
                    <i class="uil-money-bill"></i>
                    <span> Transaksi Pembayaran</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('rumah_sakit') }}" class="side-nav-link">
                    <i class="ri-hospital-line"></i>
                    <span> Master Rumah Sakit</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('kamar_inap') }}" class="side-nav-link">
                    <i class="uil-bed"></i>
                    <span>Kamar Inap</span>
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

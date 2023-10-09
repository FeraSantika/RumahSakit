<div class="leftside-menu">

    <!-- Brand Logo Light -->
    {{-- <a href="{{ route('admin.home') }}" class="logo logo-light"> --}}
    @if (Auth::user()->isAdmin())
        <a href="{{ route('admin.home') }}" class="logo logo-light">
        @elseif (Auth::user()->isDokter())
            <a href="{{ route('dokter.home') }}" class="logo logo-light">
            @elseif (Auth::user()->isApoteker())
                <a href="{{ route('apoteker.home') }}" class="logo logo-light">
                @elseif (Auth::user()->isKasir())
                    <a href="{{ route('kasir.home') }}" class="logo logo-light">
                    @elseif (Auth::user()->isResepsionis())
                        <a href="{{ route('resepsionis.home') }}" class="logo logo-light">
                        @elseif (Auth::user()->isAnalisLab())
                            <a href="{{ route('analis-lab.home') }}" class="logo logo-light">
                            @else
                                <a href="{{ route('admin.home') }}" class="logo logo-light">
    @endif
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
            @foreach ($menu as $item)
                @php
                    $isActive = false;
                    $isCollapsible = false;
                    foreach ($roleuser as $roleMenu) {
                        if ($roleMenu->Menu_id == $item->Menu_id) {
                            $isCollapsible = true;
                            $isActive = true;
                            break;
                        }
                    }
                @endphp

                @if ($isCollapsible)
                    <li class="side-nav-item">
                        @if (count($item->menu) > 0)
                            <a data-bs-toggle="collapse" href="#sidebar{{ $item->Menu_id }}" aria-expanded="false"
                                aria-controls="sidebar{{ $item->Menu_id }}" class="side-nav-link">
                                <i class="uil-navigator"></i>
                                <span> {{ $item->Menu_name }} </span>
                            </a>
                            <div class="collapse" id="sidebar{{ $item->Menu_id }}">
                                <ul class="side-nav-second-level">
                                    @foreach ($item->menu as $sub)
                                        <li>
                                            <a class="nav-link"
                                                href="{{ url('admin/' . $sub->Menu_link) }}">{{ $sub->Menu_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a class="side-nav-link" href="{{ url('admin/' . $item->Menu_link) }}">
                                <i class="uil-navigator"></i>
                                <span> {{ $item->Menu_name }} </span>
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-users-alt"></i>
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
                <a data-bs-toggle="collapse" href="#sidebarObat" aria-expanded="false" aria-controls="sidebarDashboards"
                    class="side-nav-link">
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
                <a href="{{ route('rumah_sakit') }}" class="side-nav-link">
                    <i class="ri-hospital-line"></i>
                    <span> Master Rumah Sakit</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('tindakan') }}" class="side-nav-link">
                    <i class=" uil-syringe"></i>
                    <span> Master Tindakan</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPoli" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
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
                <a href="{{ route('kamar_inap') }}" class="side-nav-link">
                    <i class="uil-bed"></i>
                    <span>Kamar Inap</span>
                </a>
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
                            <a class="nav-link {{ Route::current()->getName() == 'daftar-pasienjalan' ? 'active' : '' }}"
                                href="{{ route('daftar-pasienjalan') }}">Pasien Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'daftar.pasieninap' ? 'active' : '' }}"
                                href="{{ route('daftar.pasieninap') }}">Pasien Rawat Inap</a>
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
                            <a class="nav-link {{ Route::current()->getName() == 'list-daftar-pasienJalan' ? 'active' : '' }}"
                                href="{{ route('list-daftar-pasienJalan') }}">Pasien Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'list-daftar-pasienInap' ? 'active' : '' }}"
                                href="{{ route('list-daftar-pasienInap') }}">Pasien Rawat Inap</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('transaksi-obat') }}" class="side-nav-link">
                    <i class="uil-money-bill"></i>
                    <span> Transaksi Obat Rawat Jalan</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebartransaksipembayaran" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-money-bill"></i>
                    <span> Transaksi Pembayaran </span>
                </a>
                <div class="collapse" id="sidebartransaksipembayaran">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'transaksi-pembayaran-rawatjalan' ? 'active' : '' }}"
                                href="{{ route('transaksi-pembayaran-rawatjalan') }}"> Pasien Rawat Jalan </a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'transaksi-pembayaran-rawatinap' ? 'active' : '' }}"
                                href="{{ route('transaksi-pembayaran-rawatinap') }}"> Pasien Rawat Inap</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarlaporanpendaftaran" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span> Laporan Pendaftaran</span>
                </a>
                <div class="collapse" id="sidebarlaporanpendaftaran">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan-pasienJalan' ? 'active' : '' }}"
                                href="{{ route('laporan-pasienJalan') }}"> Pasien Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan-pasienInap' ? 'active' : '' }}"
                                href="{{ route('laporan-pasienInap') }}"> Pasien Rawat Inap </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarlaporanobat" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span> Laporan Obat</span>
                </a>
                <div class="collapse" id="sidebarlaporanobat">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan-obatJalan' ? 'active' : '' }}"
                                href="{{ route('laporan-obatJalan') }}"> Pasien Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan-obatInap' ? 'active' : '' }}"
                                href="{{ route('laporan-obatInap') }}"> Pasien Rawat Inap </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarlaporanhasil" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span> Laporan Hasil</span>
                </a>
                <div class="collapse" id="sidebarlaporanhasil">
                    <ul class="side-nav-second-level">
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan-hasilpasienJalan' ? 'active' : '' }}"
                                href="{{ route('laporan-hasilpasienJalan') }}"> Pasien Rawat Jalan</a>
                        </li>
                        <li>
                            <a class="nav-link {{ Route::current()->getName() == 'laporan-hasilpasienInap' ? 'active' : '' }}"
                                href="{{ route('laporan-hasilpasienInap') }}"> Pasien Rawat Inap </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul> --}}
        </ul>

        {{-- <ul class="side-nav">
            @foreach ($menus as $menu)
                <li class="side-nav-item">
                    <a href="{{ $menu->Menu_link }}" class="side-nav-link">
                        <i class="uil-users-alt"></i>
                        <span>{{ $menu->Menu_name }}</span>
                    </a>
                </li>
            @endforeach
        </ul> --}}


        <!--- End Sidemenu -->
        <div class="clearfix"></div>
    </div>
</div>

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AksesLabController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\AksespoliController;
use App\Http\Controllers\HomeKasirController;
use App\Http\Controllers\KamarInapController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeDokterController;
use App\Http\Controllers\RumahsakitController;
use App\Http\Controllers\TindakanLabController;
use App\Http\Controllers\HomeApotekerController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeAnalisLabController;
use App\Http\Controllers\TransaksiObatController;
use App\Http\Controllers\HomeResepsionisController;
use App\Http\Controllers\ListdaftarpasienController;
use App\Http\Controllers\ListRujukanPasienController;
use App\Http\Controllers\LaporanObatRawatInapController;
use App\Http\Controllers\ListdaftarpasienInapController;
use App\Http\Controllers\LaporanHasilRawatInapController;
use App\Http\Controllers\LaporanObatRawatJalanController;
use App\Http\Controllers\ListRujukanPasienInapController;
use App\Http\Controllers\PendaftaranPasienInapController;
use App\Http\Controllers\LaporanHasilRawatJalanController;
use App\Http\Controllers\LaporanPasienRawatInapController;
use App\Http\Controllers\PendaftaranPasienJalanController;
use App\Http\Controllers\LaporanPasienRawatJalanController;
use App\Http\Controllers\TransaksiPembayaranRawatInapController;
use App\Http\Controllers\TransaksiPembayaranRawatJalanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('logout', [LoginController::class, 'logout']);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('Adminlogin');
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('Adminregister');

Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
Route::get('/admin/home-apoteker', [HomeApotekerController::class, 'index'])->name('apoteker.home');
Route::get('/admin/home-dokter', [HomeDokterController::class, 'index'])->name('dokter.home');
Route::get('/admin/home-kasir', [HomeKasirController::class, 'index'])->name('kasir.home');
Route::get('/admin/home-resepsionis', [HomeResepsionisController::class, 'index'])->name('resepsionis.home');
Route::get('/admin/home-analis-lab', [HomeAnalisLabController::class, 'index'])->name('analis-lab.home');

Route::get('/tampil', [App\Http\Controllers\HomeController::class, 'tampil'])->name('tampil');
Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/admin/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

Route::get('/admin/role', [RoleController::class, 'index'])->name('role');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('role.create');
Route::post('/admin/role/store', [RoleController::class, 'store'])->name('role.store');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::delete('/admin/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

Route::get('/admin/user', [UserController::class, 'index'])->name('user');
Route::get('/admin/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/admin/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/admin/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/admin/pasien', [PasienController::class, 'index'])->name('pasien');
Route::get('/admin/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
Route::post('/admin/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
Route::get('/admin/pasien/edit/{id}', [PasienController::class, 'edit'])->name('pasien.edit');
Route::post('/admin/pasien/update/{id}', [PasienController::class, 'update'])->name('pasien.update');
Route::delete('/admin/pasien/destroy/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
Route::delete('/admin/pasien/destroysearch/{id}', [PasienController::class, 'destroysearch'])->name('pasien.destroysearch');
Route::get('/search/pasien', [PasienController::class, 'search'])->name('search.pasien');
Route::get('/admin/pasien/detail/{id}', [PasienController::class, 'detail'])->name('detail.pasien');

Route::get('/admin/poli', [PoliController::class, 'index'])->name('poli');
Route::get('/admin/poli/create', [PoliController::class, 'create'])->name('poli.create');
Route::post('/admin/poli/store', [PoliController::class, 'store'])->name('poli.store');
Route::get('/admin/poli/edit/{id}', [PoliController::class, 'edit'])->name('poli.edit');
Route::post('/admin/poli/update/{id}', [PoliController::class, 'update'])->name('poli.update');
Route::delete('/admin/poli/destroy/{id}', [PoliController::class, 'destroy'])->name('poli.destroy');

Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/admin/menu/store', [MenuController::class, 'store'])->name('menu.store');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::post('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/admin/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

Route::get('/admin/daftar-pasienjalan', [PendaftaranPasienJalanController::class, 'index'])->name('daftar-pasienjalan');
Route::get('/admin/daftar-pasienjalan/create', [PendaftaranPasienJalanController::class, 'create'])->name('daftar-pasienjalan.create');
Route::post('/admin/daftar-pasienjalan/store', [PendaftaranPasienJalanController::class, 'store'])->name('daftar-pasienjalan.store');
Route::get('/admin/daftar-pasienjalan/edit/{id}', [PendaftaranPasienJalanController::class, 'edit'])->name('daftar-pasienjalan.edit');
Route::post('/admin/daftar-pasienjalan/update/{id}', [PendaftaranPasienJalanController::class, 'update'])->name('daftar-pasienjalan.update');
Route::delete('/admin/daftar-pasienjalan/destroy/{id}', [PendaftaranPasienJalanController::class, 'destroy'])->name('daftar-pasienjalan.destroy');
Route::get('/autocomplete_pasien', [PendaftaranPasienJalanController::class, 'autocomplete'])->name('autocomplete_pasien');
Route::get('/search/daftar-pasien', [PendaftaranPasienJalanController::class, 'search'])->name('search.daftar-pasien');

Route::get('/admin/akses-poli', [AksespoliController::class, 'index'])->name('akses-poli');
Route::get('/admin/akses-poli/create', [AksespoliController::class, 'create'])->name('akses-poli.create');
Route::post('/admin/akses-poli/store', [AksespoliController::class, 'store'])->name('akses-poli.store');
Route::get('/admin/akses-poli/edit/{id}', [AksespoliController::class, 'edit'])->name('akses-poli.edit');
Route::post('/admin/akses-poli/update/{id}', [AksespoliController::class, 'update'])->name('akses-poli.update');
Route::delete('/admin/akses-poli/destroy/{id}', [AksespoliController::class, 'destroy'])->name('akses-poli.destroy');

Route::get('/admin/list-daftar-pasienJalan', [ListdaftarpasienController::class, 'index'])->name('list-daftar-pasienJalan');
Route::get('/search/list-daftar-pasienJalan', [ListdaftarpasienController::class, 'search'])->name('search.list-daftar-pasienJalan');
Route::get('/admin/list-daftar-pasienJalan/detail/{id}', [ListdaftarpasienController::class, 'detail'])->name('detail.list-daftar-pasienJalan');
Route::get('/autocomplete_obat_pasienJalan', [ListdaftarpasienController::class, 'autocomplete'])->name('autocomplete_obat_pasienJalan');
Route::get('/autocomplete_tindakan', [ListdaftarpasienController::class, 'autocomplete_tindakan'])->name('autocomplete_tindakan');
Route::get('/admin/pasien/detail/destroy/{id}', [ListdaftarpasienController::class, 'destroylist'])->name('listdaftarobat.destroy');
Route::post('/admin/pasien/detail/updatelist', [ListdaftarpasienController::class, 'updatelist'])->name('listdaftarobat.update');
Route::post('/admin/pasien/detail/insertlist', [ListdaftarpasienController::class, 'insertlist'])->name('listdaftarobat.insert');
Route::get('/admin/pasien/detail/destroy-tindakan/{id}', [ListdaftarpasienController::class, 'destroytindakan'])->name('listdaftartindakan.destroy');
Route::post('/admin/pasien/detail/insertlist-tindakan', [ListdaftarpasienController::class, 'inserttindakan'])->name('listdaftartindakan.insert');
Route::post('/admin/pasien/detail/diagnosa/{id}', [ListdaftarpasienController::class, 'updateDiagnosa'])->name('detail.pasien.diagnosa');
Route::get('/admin/pasien/detail/riwayat/{id}', [ListdaftarpasienController::class, 'detailriwayat'])->name('detail.riwayat.pasien');
Route::get('/autocomplete_rujukan', [ListdaftarpasienController::class, 'autocomplete_rujukan'])->name('autocomplete_rujukan');
Route::post('/admin/pasien/detail/insertlist-rujukan', [ListdaftarpasienController::class, 'insertrujukan'])->name('listdaftarrujukan.insert');
Route::get('/admin/pasien/detail/destroy-rujukan/{id}', [ListdaftarpasienController::class, 'destroyrujukan'])->name('listdaftarrujukan.destroy');

Route::get('/admin/list-rujukan-pasienJalan', [ListRujukanPasienController::class, 'index'])->name('list-rujukan-pasienJalan');
Route::get('/admin/list-rujukan-pasienJalan/detail/{id}', [ListRujukanPasienController::class, 'detail'])->name('detail.list-rujukan-pasienJalan');
Route::post('/admin/list-rujukan-pasienJalan/upload/{id}', [ListRujukanPasienController::class, 'uploadfile'])->name('upload.file-rujukan-pasienJalan');

Route::get('/admin/obat', [ObatController::class, 'index'])->name('obat');
Route::get('/admin/obat/create', [ObatController::class, 'create'])->name('obat.create');
Route::post('/admin/obat/store', [ObatController::class, 'store'])->name('obat.store');
Route::get('/admin/obat/edit/{id}', [ObatController::class, 'edit'])->name('obat.edit');
Route::post('/admin/obat/update/{id}', [ObatController::class, 'update'])->name('obat.update');
Route::delete('/admin/obat/destroy/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
Route::get('/search/obat', [ObatController::class, 'search'])->name('search.obat');

Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::get('/admin/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/admin/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/admin/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::post('/admin/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/admin/kategori/destroy/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
Route::get('/search/kategori', [KategoriController::class, 'search'])->name('search.kategori');

Route::get('/admin/tindakan', [TindakanController::class, 'index'])->name('tindakan');
Route::get('/admin/tindakan/create', [TindakanController::class, 'create'])->name('tindakan.create');
Route::post('/admin/tindakan/store', [TindakanController::class, 'store'])->name('tindakan.store');
Route::get('/admin/tindakan/edit/{id}', [TindakanController::class, 'edit'])->name('tindakan.edit');
Route::post('/admin/tindakan/update/{id}', [TindakanController::class, 'update'])->name('tindakan.update');
Route::delete('/admin/tindakan/destroy/{id}', [TindakanController::class, 'destroy'])->name('tindakan.destroy');
Route::get('/search/tindakan', [TindakanController::class, 'search'])->name('search.tindakan');

Route::get('/admin/transaksi-obat', [TransaksiObatController::class, 'index'])->name('transaksi-obat');
Route::get('/admin/transaksi-obat/detail/{id}', [TransaksiObatController::class, 'detail'])->name('transaksi-obat.detail');
Route::post('/admin/transaksi-obat/detail/obat/{id}', [TransaksiObatController::class, 'updateObat'])->name('transaksi-obat.detail.update');
Route::post('/admin/transaksi-obat/detail/updatelistobat', [TransaksiObatController::class, 'updatelist'])->name('transaksi-obat.list.update');
Route::get('/search/transaksi-obat', [TransaksiObatController::class, 'search'])->name('search.transaksi-obat');

Route::get('/admin/transaksi-pembayaran-rawatjalan', [TransaksiPembayaranRawatJalanController::class, 'index'])->name('transaksi-pembayaran-rawatjalan');
Route::get('/admin/transaksi-pembayaran-rawatjalan/detail/{id}', [TransaksiPembayaranRawatJalanController::class, 'detail'])->name('transaksi-pembayaran-rawatjalan.detail');
Route::post('/admin/transaksi-pembayaran-rawatjalan/detail/update/{id}', [TransaksiPembayaranRawatJalanController::class, 'transaksi'])->name('transaksi-pembayaran-rawatjalan.detail.update');
Route::post('/admin/transaksi-pembayaran-rawatjalan/detail/update/print/{id}', [TransaksiPembayaranRawatJalanController::class, 'print'])->name('transaksi-pembayaran-rawatjalan.detail.print');
Route::get('/search/transaksi-pembayaran-rawatjalan', [TransaksiPembayaranRawatJalanController::class, 'search'])->name('search.transaksi-pembayaran-rawatjalan');

Route::get('/admin/transaksi-pembayaran-rawatinap', [TransaksiPembayaranRawatInapController::class, 'index'])->name('transaksi-pembayaran-rawatinap');
Route::get('/admin/transaksi-pembayaran-rawatinap/detail/{id}', [TransaksiPembayaranRawatInapController::class, 'detail'])->name('transaksi-pembayaran-rawatinap.detail');
Route::post('/admin/transaksi-pembayaran-rawatinap/detail/update/{id}', [TransaksiPembayaranRawatInapController::class, 'transaksi'])->name('transaksi-pembayaran-rawatinap.detail.update');
Route::post('/admin/transaksi-pembayaran-rawatinap/detail/update/print/{id}', [TransaksiPembayaranRawatInapController::class, 'print'])->name('transaksi-pembayaran-rawatinap.detail.print');
Route::get('/search/transaksi-pembayaran-rawatinap', [TransaksiPembayaranRawatInapController::class, 'search'])->name('search.transaksi-pembayaran-rawatinap');

Route::get('/admin/rumah_sakit', [RumahsakitController::class, 'index'])->name('rumah_sakit');
Route::get('/admin/rumah_sakit/create', [RumahsakitController::class, 'create'])->name('rumah_sakit.create');
Route::post('/admin/rumah_sakit/store', [RumahsakitController::class, 'store'])->name('rumah_sakit.store');
Route::get('/admin/rumah_sakit/edit/{id}', [RumahsakitController::class, 'edit'])->name('rumah_sakit.edit');
Route::post('/admin/rumah_sakit/update/{id}', [RumahsakitController::class, 'update'])->name('rumah_sakit.update');
Route::delete('/admin/rumah_sakit/destroy/{id}', [RumahsakitController::class, 'destroy'])->name('rumah_sakit.destroy');

Route::get('/admin/daftar-pasieninap', [PendaftaranPasienInapController::class, 'index'])->name('daftar.pasieninap');
Route::get('/admin/daftar-pasieninap/create', [PendaftaranPasienInapController::class, 'create'])->name('daftar.pasieninap.create');
Route::post('/admin/daftar-pasieninap/store', [PendaftaranPasienInapController::class, 'store'])->name('daftar.pasieninap.store');
Route::get('/admin/daftar-pasieninap/edit/{id}', [PendaftaranPasienInapController::class, 'edit'])->name('daftar.pasieninap.edit');
Route::post('/admin/daftar-pasieninap/update/{id}', [PendaftaranPasienInapController::class, 'update'])->name('daftar.pasieninap.update');
Route::delete('/admin/daftar-pasieninap/destroy/{id}', [PendaftaranPasienInapController::class, 'destroy'])->name('daftar-pasieninap.destroy');
Route::get('/autocomplete_pasieninap', [PendaftaranPasienInapController::class, 'autocomplete'])->name('autocomplete_pasieninap');
Route::get('/search/daftar-pasieninap', [PendaftaranPasienInapController::class, 'search'])->name('search.daftar-pasieninap');

Route::get('/admin/kamar_inap', [KamarInapController::class, 'index'])->name('kamar_inap');
Route::get('/admin/kamar_inap/create', [KamarInapController::class, 'create'])->name('kamar_inap.create');
Route::post('/admin/kamar_inap/store', [KamarInapController::class, 'store'])->name('kamar_inap.store');
Route::get('/admin/kamar_inap/edit/{id}', [KamarInapController::class, 'edit'])->name('kamar_inap.edit');
Route::post('/admin/kamar_inap/update/{id}', [KamarInapController::class, 'update'])->name('kamar_inap.update');
Route::delete('/admin/kamar_inap/destroy/{id}', [KamarInapController::class, 'destroy'])->name('kamar_inap.destroy');

Route::get('/admin/list-daftar-pasienInap', [ListdaftarpasienInapController::class, 'index'])->name('list-daftar-pasienInap');
Route::get('/search/list-daftar-pasienInap', [ListdaftarpasienInapController::class, 'search'])->name('search.list-daftar-pasienInap');
Route::get('/admin/list-daftar-pasienInap/detail/{id}', [ListdaftarpasienInapController::class, 'detail'])->name('detail.list-daftar-pasienInap');
Route::get('/autocomplete_obat_pasienInap', [ListdaftarpasienInapController::class, 'autocomplete'])->name('autocomplete_obat_pasienInap');
Route::get('/autocomplete_tindakan_pasienInap', [ListdaftarpasienInapController::class, 'autocomplete_tindakan'])->name('autocomplete_tindakan_pasienInap');
Route::get('/admin/pasienInap/detail/destroy/{id}', [ListdaftarpasienInapController::class, 'destroylist'])->name('listdaftarobat_pasienInap.destroy');
Route::post('/admin/pasienInap/detail/updatelist', [ListdaftarpasienInapController::class, 'updatelistobat'])->name('detail.updateobatpasien');
Route::post('/admin/pasienInap/detail/insertlistobat', [ListdaftarpasienInapController::class, 'insertlistobat'])->name('detail.insertobatpasien');
Route::get('/admin/pasienInap/detail/destroy-tindakan/{id}', [ListdaftarpasienInapController::class, 'destroytindakan'])->name('listdaftartindakan_pasienInap.destroy');
Route::post('/admin/pasienInap/detail/insertlist-tindakan', [ListdaftarpasienInapController::class, 'inserttindakan'])->name('listdaftartindakan_pasienInap.insert');
Route::post('/admin/pasienInap/detail/updatelist-tindakan', [ListdaftarpasienInapController::class, 'updatetindakan'])->name('listdaftartindakan_pasienInap.update');
Route::get('/admin/pasienInap/detail/riwayat/{id}', [ListdaftarpasienInapController::class, 'detailriwayat'])->name('detail.riwayat.pasienInap');
Route::get('/autocomplete_kamar_pasienInap', [ListdaftarpasienInapController::class, 'autocomplete_kamar'])->name('autocomplete_kamar_pasienInap');
Route::post('/admin/pasienInap/detail/insertkamarpasien', [ListdaftarpasienInapController::class, 'insertkamarpasien'])->name('detail.insertkamarpasien');
Route::post('/admin/pasienInap/detail/updatekamarpasien', [ListdaftarpasienInapController::class, 'updatekamarpasien'])->name('detail.updatekamarpasien');
Route::get('/admin/pasienInap/detail/destroykamarpasien/{id}', [ListdaftarpasienInapController::class, 'destroykamarpasien'])->name('detail.destroykamarpasien');
Route::post('/admin/pasienInap/detail/insertdiagnosapasien', [ListdaftarpasienInapController::class, 'insertdiagnosapasien'])->name('listdaftardiagnosa_pasienInap.insert');
Route::post('/admin/pasienInap/detail/diagnosa', [ListdaftarpasienInapController::class, 'updatediagnosapasien'])->name('listdaftardiagnosa_pasienInap.update');
Route::get('/admin/pasienInap/detail/destroydiagnosa/{id}', [ListdaftarpasienInapController::class, 'destroydiagnosapasien'])->name('detail.destroydiagnosapasien');
Route::get('/api/get_obat', [ListdaftarpasienInapController::class, 'getObat'])->name('detail.insertobatoption');
Route::get('/admin/pasienInap/detail/datakamarpasien/{id}', [ListdaftarpasienInapController::class, 'datakamar'])->name('data-kamar');
Route::post('/admin/pasienInap/detail/status-pemeriksaan', [ListdaftarpasienInapController::class, 'statuspemeriksaanupdate'])->name('detail.pemeriksaanpasieninap');
Route::get('/autocomplete_rujukan_pasieninap', [ListdaftarpasienInapController::class, 'autocomplete_rujukan'])->name('autocomplete_rujukan_pasieninap');
Route::post('/admin/pasienInap/detail/insertlist-rujukan', [ListdaftarpasienInapController::class, 'insertrujukan'])->name('listdaftarrujukanpasieninap.insert');
Route::get('/admin/pasienInap/detail/destroy-rujukan/{id}', [ListdaftarpasienInapController::class, 'destroyrujukan'])->name('listdaftarrujukanpasieninap.destroy');

Route::get('/admin/list-rujukan-pasienInap', [ListRujukanPasienInapController::class, 'index'])->name('list-rujukan-pasienInap');
Route::get('/admin/list-rujukan-pasienInap/detail/{id}', [ListRujukanPasienInapController::class, 'detail'])->name('detail.list-rujukan-pasienInap');
Route::post('/admin/list-rujukan-pasienInap/upload/{id}', [ListRujukanPasienInapController::class, 'uploadfile'])->name('upload.file-rujukan-pasienInap');

Route::get('/admin/laporan-pasienInap', [LaporanPasienRawatInapController::class, 'index'])->name('laporan-pasienInap');
Route::get('/admin/laporan-pasienInap/get_data', [LaporanPasienRawatInapController::class, 'getDataByDate'])->name('laporan-pasienInap.get_data');
Route::get('/admin/laporan-pasienInap/export-pdf', [LaporanPasienRawatInapController::class, 'exportPDF'])->name('laporan-pasienInap.export-pdf');
Route::get('/admin/laporan-pasienInap/export-excel', [LaporanPasienRawatInapController::class, 'exportExcel'])->name('laporan-pasienInap.export-excel');

Route::get('/admin/laporan-pasienJalan', [LaporanPasienRawatJalanController::class, 'index'])->name('laporan-pasienJalan');
Route::get('/admin/laporan-pasienJalan/get_data', [LaporanPasienRawatJalanController::class, 'getDataByDate'])->name('laporan-pasienJalan.get_data');
Route::get('/admin/laporan-pasienJalan/export-pdf', [LaporanPasienRawatJalanController::class, 'exportPDF'])->name('laporan-pasienJalan.export-pdf');
Route::get('/admin/laporan-pasienJalan/export-excel', [LaporanPasienRawatJalanController::class, 'exportExcel'])->name('laporan-pasienJalan.export-excel');

Route::get('/admin/laporan-obatJalan', [LaporanObatRawatJalanController::class, 'index'])->name('laporan-obatJalan');
Route::get('/admin/laporan-obatJalan/get_data', [LaporanObatRawatJalanController::class, 'getDataByDate'])->name('laporan-obatJalan.get_data');
Route::get('/admin/laporan-obatJalan/export-pdf', [LaporanObatRawatJalanController::class, 'exportPDF'])->name('laporan-obatJalan.export-pdf');
Route::get('/admin/laporan-obatJalan/export-excel', [LaporanObatRawatJalanController::class, 'exportExcel'])->name('laporan-obatJalan.export-excel');

Route::get('/admin/laporan-obatInap', [LaporanObatRawatInapController::class, 'index'])->name('laporan-obatInap');
Route::get('/admin/laporan-obatInap/get_data', [LaporanObatRawatInapController::class, 'getDataByDate'])->name('laporan-obatInap.get_data');
Route::get('/admin/laporan-obatInap/export-pdf', [LaporanObatRawatInapController::class, 'exportPDF'])->name('laporan-obatInap.export-pdf');
Route::get('/admin/laporan-obatInap/export-excel', [LaporanObatRawatInapController::class, 'exportExcel'])->name('laporan-obatInap.export-excel');

Route::get('/admin/laporan-hasilpasienJalan', [LaporanHasilRawatJalanController::class, 'index'])->name('laporan-hasilpasienJalan');
Route::get('/admin/laporan-hasilpasienJalan/get_data', [LaporanHasilRawatJalanController::class, 'getDataByDate'])->name('laporan-hasilpasienJalan.get_data');
Route::get('/admin/laporan-hasilpasienJalan/export-pdf', [LaporanHasilRawatJalanController::class, 'exportPDF'])->name('laporan-hasilpasienJalan.export-pdf');
Route::get('/admin/laporan-hasilpasienJalan/export-excel', [LaporanHasilRawatJalanController::class, 'exportExcel'])->name('laporan-hasilpasienJalan.export-excel');

Route::get('/admin/laporan-hasilpasienInap', [LaporanHasilRawatInapController::class, 'index'])->name('laporan-hasilpasienInap');
Route::get('/admin/laporan-hasilpasienInap/get_data', [LaporanHasilRawatInapController::class, 'getDataByDate'])->name('laporan-hasilpasienInap.get_data');
Route::get('/admin/laporan-hasilpasienInap/export-pdf', [LaporanHasilRawatInapController::class, 'exportPDF'])->name('laporan-hasilpasienInap.export-pdf');
Route::get('/admin/laporan-hasilpasienInap/export-excel', [LaporanHasilRawatInapController::class, 'exportExcel'])->name('laporan-hasilpasienInap.export-excel');

Route::get('/admin/lab', [LabController::class, 'index'])->name('lab');
Route::get('/admin/lab/create', [LabController::class, 'create'])->name('lab.create');
Route::post('/admin/lab/store', [LabController::class, 'store'])->name('lab.store');
Route::get('/admin/lab/edit/{id}', [LabController::class, 'edit'])->name('lab.edit');
Route::post('/admin/lab/update/{id}', [LabController::class, 'update'])->name('lab.update');
Route::delete('/admin/lab/destroy/{id}', [LabController::class, 'destroy'])->name('lab.destroy');

Route::get('/admin/akses-lab', [AksesLabController::class, 'index'])->name('akses-lab');
Route::get('/admin/akses-lab/create', [AksesLabController::class, 'create'])->name('akses-lab.create');
Route::post('/admin/akses-lab/store', [AksesLabController::class, 'store'])->name('akses-lab.store');
Route::get('/admin/akses-lab/edit/{id}', [AksesLabController::class, 'edit'])->name('akses-lab.edit');
Route::post('/admin/akses-lab/update/{id}', [AksesLabController::class, 'update'])->name('akses-lab.update');
Route::delete('/admin/akses-lab/destroy/{id}', [AksesLabController::class, 'destroy'])->name('akses-lab.destroy');

Route::get('/admin/tindakan-lab', [TindakanLabController::class, 'index'])->name('tindakan-lab');
Route::get('/admin/tindakan-lab/create', [TindakanLabController::class, 'create'])->name('tindakan-lab.create');
Route::post('/admin/tindakan-lab/store', [TindakanLabController::class, 'store'])->name('tindakan-lab.store');
Route::get('/admin/tindakan-lab/edit/{id}', [TindakanLabController::class, 'edit'])->name('tindakan-lab.edit');
Route::post('/admin/tindakan-lab/update/{id}', [TindakanLabController::class, 'update'])->name('tindakan-lab.update');
Route::delete('/admin/tindakan-lab/destroy/{id}', [TindakanLabController::class, 'destroy'])->name('tindakan-lab.destroy');
Route::get('/search/tindakan-lab', [TindakanLabController::class, 'search'])->name('search.tindakan-lab');

Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('jadwal-dokter');
Route::get('/admin/jadwal-dokter/create', [JadwalDokterController::class, 'create'])->name('jadwal-dokter.create');
Route::post('/admin/jadwal-dokter/store', [JadwalDokterController::class, 'store'])->name('jadwal-dokter.store');
Route::get('/admin/jadwal-dokter/edit/{id}', [JadwalDokterController::class, 'edit'])->name('jadwal-dokter.edit');
Route::post('/admin/jadwal-dokter/update/{id}', [JadwalDokterController::class, 'update'])->name('jadwal-dokter.update');
Route::delete('/admin/jadwal-dokter/destroy/{id}', [JadwalDokterController::class, 'destroy'])->name('jadwal-dokter.destroy');
Route::get('/autocomplete_jadwal-dokter', [JadwalDokterController::class, 'autocomplete'])->name('autocomplete_jadwal-dokter');
Route::get('/search/jadwal-dokter', [JadwalDokterController::class, 'search'])->name('search.jadwal-dokter');

Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.view');
Route::get('/admin/antrian', [AntrianController::class, 'antrian'])->name('antrian');
Route::post('/admin/antrian/update', [AntrianController::class, 'hitungantrian'])->name('antrian-update');
Route::post('/admin/antrian/updatestatus', [AntrianController::class, 'ubahstatus'])->name('antrian-updatestatus');
Route::get('/get-nomor-antrian', [AntrianController::class, 'getNomorAntrian'])->name('get-nomor-antrian');
Route::get('/get-nama-poli', [AntrianController::class, 'getNamaPoli'])->name('get-nama-poli');


<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\BaseUiController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\AksespoliController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DaftaronlineController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ListdaftarpasienController;

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
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
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

Route::get('/admin/daftar-online', [DaftaronlineController::class, 'index'])->name('daftar.online');
Route::get('/admin/daftar-online/create', [DaftaronlineController::class, 'create'])->name('daftar.online.create');
Route::post('/admin/daftar-online/store', [DaftaronlineController::class, 'store'])->name('daftar.online.store');
Route::get('/admin/daftar-online/edit/{id}', [DaftaronlineController::class, 'edit'])->name('daftar.online.edit');
Route::post('/admin/daftar-online/update/{id}', [DaftaronlineController::class, 'update'])->name('daftar.online.update');
Route::delete('/admin/daftar-online/destroy/{id}', [DaftaronlineController::class, 'destroy'])->name('daftar-online.destroy');
Route::get('/autocomplete_pasien', [DaftaronlineController::class, 'autocomplete'])->name('autocomplete_pasien');
Route::get('/search/daftar-pasien', [DaftaronlineController::class, 'search'])->name('search.daftar-pasien');

Route::get('/admin/akses-poli', [AksespoliController::class, 'index'])->name('akses-poli');
Route::get('/admin/akses-poli/create', [AksespoliController::class, 'create'])->name('akses-poli.create');
Route::post('/admin/akses-poli/store', [AksespoliController::class, 'store'])->name('akses-poli.store');
Route::get('/admin/akses-poli/edit/{id}', [AksespoliController::class, 'edit'])->name('akses-poli.edit');
Route::post('/admin/akses-poli/update/{id}', [AksespoliController::class, 'update'])->name('akses-poli.update');
Route::delete('/admin/akses-poli/destroy/{id}', [AksespoliController::class, 'destroy'])->name('akses-poli.destroy');

Route::get('/admin/list-daftar-pasien', [ListdaftarpasienController::class, 'index'])->name('list-daftar-pasien');
Route::get('/search/list-daftar-pasien', [ListdaftarpasienController::class, 'search'])->name('search.list-daftar-pasien');
Route::get('/admin/list-daftar-pasien/detail/{id}', [ListdaftarpasienController::class, 'detail'])->name('detail.list-daftar-pasien');
Route::get('/autocomplete_obat', [ListdaftarpasienController::class, 'autocomplete'])->name('autocomplete_obat');
Route::get('/autocomplete_tindakan', [ListdaftarpasienController::class, 'autocomplete_tindakan'])->name('autocomplete_tindakan');
Route::get('/admin/pasien/detail/destroy/{id}', [ListdaftarpasienController::class, 'destroylist'])->name('listdaftarobat.destroy');
Route::post('/admin/pasien/detail/updatelist', [ListdaftarpasienController::class, 'updatelist'])->name('listdaftarobat.update');
Route::post('/admin/pasien/detail/insertlist', [ListdaftarpasienController::class, 'insertlist'])->name('listdaftarobat.insert');
Route::get('/admin/pasien/detail/destroy-tindakan/{id}', [ListdaftarpasienController::class, 'destroytindakan'])->name('listdaftartindakan.destroy');
Route::post('/admin/pasien/detail/insertlist-tindakan', [ListdaftarpasienController::class, 'inserttindakan'])->name('listdaftartindakan.insert');
Route::post('/admin/pasien/detail/diagnosa/{id}', [ListdaftarpasienController::class, 'updateDiagnosa'])->name('detail.pasien.diagnosa');
Route::get('/admin/pasien/detail/riwayat/{id}', [ListdaftarpasienController::class, 'detailriwayat'])->name('detail.riwayat.pasien');
// Route::get('/list-daftar-pasien/autocomplete_obat', [ListdaftarpasienController::class, 'autocomplete'])->name('autocomplete_obat.list-daftar-pasien');
// Route::get('/list-daftar-pasien/autocomplete_tindakan', [ListdaftarpasienController::class, 'autocomplete_tindakan'])->name('autocomplete_tindakan.list-daftar-pasien');
//Route::get('/admin/list-daftar-pasien/detail/destroy/{id}', [ListdaftarpasienController::class, 'destroylist'])->name('listdaftarpasien-obat.destroy');
//Route::post('/admin/list-daftar-pasien/detail/updatelist', [ListdaftarpasienController::class, 'updatelist'])->name('listdaftarpasien-obat.update');
// Route::post('/admin/list-daftar-pasien/detail/insertlist', [ListdaftarpasienController::class, 'insertlist'])->name('listdaftarpasien-obat.insert');
// Route::get('/admin/list-daftar-pasien/detail/destroy-tindakan/{id}', [ListdaftarpasienController::class, 'destroytindakan'])->name('listdaftarpasien-tindakan.destroy');
// Route::post('/admin/list-daftar-pasien/detail/insertlist-tindakan', [ListdaftarpasienController::class, 'inserttindakan'])->name('listdaftarpasien-tindakan.insert');

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

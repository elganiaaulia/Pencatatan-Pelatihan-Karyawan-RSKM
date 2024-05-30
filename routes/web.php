<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PelatihanPerIdController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->group(function () {

	// Route group admin prefix
		Route::middleware(['admin'])->prefix('admin')->group(function () {
			Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
			Route::post('/upload', [HomeController::class, 'upload'])->name('upload.tinymce');
			Route::put('/dashboard/update', [HomeController::class, 'update'])->name('update.tinymce');
			Route::resource('/users', UserController::class);
			Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
			Route::get('/user/export', [UserController::class, 'export'])->name('user.export');
			Route::resource('/periode', PeriodeController::class);
			Route::resource('/pelatihan', PelatihanController::class)->except(['index']);
			Route::get('/pelatihan/user/{year}/{id}', [PelatihanController::class, 'pelatihanById'])->name('pelatihan.user');
			Route::get('/pelatihan/validate/{year}', [PelatihanController::class, 'pelatihanValidation'])->name('pelatihan.validate');
			Route::get('/pelatihan/periode/{year}', [PelatihanController::class, 'pelatihanByPeriode'])->name('pelatihan.periode');
			Route::get('/periode/{year}/grafik', [PelatihanController::class, 'pelatihanByPeriodeGrafik'])->name('pelatihan.grafik');
			Route::get('/pelatihan/export/{year}/{id}', [PelatihanPerIdController::class, 'export'])->name('export.pelatihan');
			Route::get('/pelatihan/export-all/{year}', [PelatihanController::class, 'ExportByYear'])->name('export.user.periode');
		});
		Route::middleware(['karyawan'])->prefix('karyawan')->group(function () {
			Route::get('/dashboard', [KaryawanController::class, 'index'])->name('karyawan.dashboard');
			Route::get('/password-change', [KaryawanController::class, 'passwordChange'])->name('karyawan.password');
			Route::put('/password-update/{id}', [KaryawanController::class, 'passwordUpdate'])->name('karyawan.password.update');
			Route::resource('/pencatatan', PelatihanPerIdController::class)->except(['create', 'store', 'update']);
			Route::get('/pencatatan/{year}/create', [PelatihanPerIdController::class, 'createByYear'])->name('pencatatan.create');
			Route::post('/pencatatan/{year}/store', [PelatihanPerIdController::class, 'storeByYear'])->name('pencatatan.store');
			Route::put('/pencatatan/{year}/update/{id}', [PelatihanPerIdController::class, 'update'])->name('pencatatan.update');
			Route::get('/pencatatan/{year}/export/{id}', [PelatihanPerIdController::class, 'export'])->name('export.pencatatan');
		});
	Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Auth::routes(['verify' => false,
	'reset' => false,
	'confirm' => false,
	'register' => false,	
	'logout' => false,
	'login' => false,
]);
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
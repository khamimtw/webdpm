<?php

use App\Http\Controllers\AdminIndexController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DiagnosaUserController;
use \App\Http\Controllers\PakarLevelController;
use \App\Http\Controllers\PakarPengobatanController;
use \App\Http\Controllers\PakarHasilDiagnosaController;
use \App\Http\Controllers\PakarJawabanController;
use \App\Http\Controllers\AdminGejalaController;
use App\Http\Controllers\jawabanController;
use \App\Http\Controllers\pertanyaanController;

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

Route::resource('/', \App\Http\Controllers\UserIndexController::class);



Route::group(['middleware' => 'guest'], function() {
    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'actionlogin'])->name('actionlogin');
    Route::get('/user_diagnosa',[DiagnosaUserController::class, 'create'])->name('create');
    Route::post('/user_diagnosa',[DiagnosaUserController::class, 'store'])->name('diagnosa.user');
    Route::get('/user_hasil',[DiagnosaUserController::class, 'index'])->name('index');
    Route::get('/user_pertanyaan',[pertanyaanController::class, 'pertanyaan'])->name('pertanyaan');
    Route::get('/user_jawaban',[jawabanController::class, 'index'])->name('jawaban');
    Route::post('/user_input_pertanyaan',[pertanyaanController::class, 'store'])->name('pertanyaan.input');

});
Route::group(['middleware' => ['auth', 'checkrole:1,2']], function() {
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'actionlogout'])->name('actionLogout');
    Route::get('/redirect', [\App\Http\Controllers\RedirectController::class, 'cek']);
});


Route::group(['middleware' => ['auth', 'checkrole:2']], function() {
    Route::resource('/pakar_dashboard', \App\Http\Controllers\PakarIndexController::class);

    Route::get('/pakar_level',[PakarLevelController::class,'index'])->name('index.level');
    Route::post('/pakar_level_tambah',[PakarLevelController::class,'store'])->name('store.level');
    Route::get('/pakar_level_edit',[PakarLevelController::class,'edit'])->name('edit.level');
    Route::post('/pakar_level_update',[PakarLevelController::class,'update'])->name('update.level');
    Route::delete('/pakar_level_delete/{id}',[PakarLevelController::class,'destroy'])->name('destroy.level');
        
    Route::get('/pakar_Pengobatan',[PakarPengobatanController::class,'index'])->name('index.pengobatan');
    Route::post('/pakar_Pengobatan_tambah',[PakarPengobatanController::class,'store'])->name('store.pengobatan');
    Route::get('/pakar_Pengobatan_edit',[PakarPengobatanController::class,'edit'])->name('edit.pengobatan');
    Route::post('/pakar_Pengobatan_update',[PakarPengobatanController::class,'update'])->name('update.pengobatan');
    Route::delete('/pakar_Pengobatan_delete/{id}',[PakarPengobatanController::class,'destroy'])->name('destroy.pengobatan');
    Route::get('/pakar_riwayat',[PakarHasilDiagnosaController::class, 'hasil'])->name('index');
    Route::delete('/pakar_diagnosa_delete/{id}',[PakarHasilDiagnosaController::class,'destroy'])->name('destroy.diagnosa');

    Route::get('/pakar_pertanyaan',[PakarJawabanController::class, 'index'])->name('show.pertanyaan');
    Route::delete('/pakar_pertanyaan_delete/{id}',[PakarJawabanController::class,'destroy'])->name('destroy.pertanyaan');
    Route::post('/pakar_jawaban/{id}',[PakarJawabanController::class, 'answer'])->name('input.jawaban');
    Route::post('/pakar_edit_jawaban/{id}',[PakarJawabanController::class, 'updateAnswer'])->name('edit.jawaban');
    Route::put('/pakar_edit_jawaban/{id}',[PakarJawabanController::class, 'updateAnswer'])->name('edit.jawaban');

    Route::get('/profile_pakar', [\App\Http\Controllers\PakarProfileController::class, 'index'])->name('pakar.profile');
    Route::put('/profile_pakar_edit', [\App\Http\Controllers\PakarProfileController::class, 'update'])->name('update_profile_pakar');
    
});

Route::group(['middleware' => ['auth', 'checkrole:1']], function() {
    Route::get('/superadmin', [AdminIndexController::class, 'index']);
    Route::get('/superadmin.pelatihan', [AdminGejalaController::class, 'getFinalWeights'])->name('admin.pelatihan');
    Route::get('/train', [AdminGejalaController::class, 'train'])->name('trainMethod');
    Route::get('/test', [AdminGejalaController::class, 'diagnose'])->name('testMethod');
    Route::get('/profile_admin', [\App\Http\Controllers\AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile_admin_edit', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('update_profile_admin');
});


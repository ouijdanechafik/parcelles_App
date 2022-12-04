<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\ProprietaireController;

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/agents',[UsersController::class,'index'])->name('agents');
Route::get('/parcelles',[ParcelleController::class,'index'])->name('parcelles');
Route::get('/user',[UsersController::class,'user']);
Route::get('/villages',[VillageController::class,'index'])->name('villages');
Route::get('/proprietaires',[ProprietaireController::class,'index'])->name('proprietaires');

Route::post('proprietaires',[ProprietaireController::class,'search'])->name('searchp');
Route::post('villages',[VillageController::class,'search'])->name('searchv');
Route::post('agents',[UsersController::class,'search'])->name('searchagent');

Route::post('/parcelles',[ParcelleController::class,'searchparcelles'])->name('searchparcelles');

Route::get('/getdmi/{id}',[ParcelleController::class,'download'])->name('getdmi');


Route::get('/addproprietaire',[ProprietaireController::class,'addproprietaire'])->name('addproprietaire');
Route::post('/saveproprietaire',[ProprietaireController::class,'save'])->name('saveproprietaire');
Route::post('/updateproprietaire', [ProprietaireController::class,'update'])->name('updateproprietaire');
Route::get('/deleteproprietaire/{id}', [ProprietaireController::class,'deleteproprietaire'])->name('deleteproprietaire');
Route::get('/editproprietaire/{id}', [ProprietaireController::class,'editproprietaire'])->name('editproprietaire');


Route::get('/addvillage',[VillageController::class,'addvillage'])->name('addvillage');
Route::post('/savevillage',[VillageController::class,'savevillage'])->name('savevillage');
Route::post('/updatevillage', [VillageController::class,'updatevillage'])->name('updatevillage');
Route::get('/deletevillage/{id}', [VillageController::class,'deletevillage'])->name('deletevillage');
Route::get('/editvillage/{id}', [VillageController::class,'editvillage'])->name('editvillage');



Route::get('/addparcelle',[ParcelleController::class,'addparcelle'])->name('addparcelle');
Route::post('/saveparcelle', [ParcelleController::class,'save'])->name('saveparcelle');
Route::post('/updateparcelle', [ParcelleController::class,'updateparcelle'])->name('updateparcelle');
Route::get('/deleteparcelle/{id}', [ParcelleController::class,'deleteparcelle'])->name('deleteparcelle');
Route::get('/editparcelle/{id}', [ParcelleController::class,'editparcelle'])->name('editparcelle');



/* Route::get('/adduser', [UsersController::class,'adduser'])->name('adduser');
Route::post('/saveuser',[UsersController::class,'saveuser'])->name('saveuser');
Route::post('/Updateuser', [UsersController::class,'Updateuser'])->name('Updateuser');
Route::get('/deleteuser/{id}', [UsersController::class,'deleteuser'])->name('deleteuser');
Route::get('/edituser/{id}', [UsersController::class,'edituser'])->name('edituser'); */

Route::get('users', [UsersController::class, 'index'])->name('users.index');
Route::post('users/store', [UsersController::class, 'store'])->name('users.store');
Route::get('users/edit/{id}/', [UsersController::class, 'edit'])->name('users.edit');
Route::post('users/update', [UsersController::class, 'update'])->name('users.update');
Route::get('users/destroy/{id}/', [UsersController::class, 'destroy']);
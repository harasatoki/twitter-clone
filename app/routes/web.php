<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
    return view('welcome');
});
<<<<<<< HEAD

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hello', function () {
    return view('welcome');
=======
Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');

Route::get('/hello', function () {
    echo 'welcome';
>>>>>>> e3dc12413b04e869c9dacf2cbb9007d854da938d
});
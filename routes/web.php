<?php

use App\Http\Controllers\TestimonyFormController;
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

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get('/admin', function () {
    return view('Admin.layout.main');
})->name("admin");

Route::get('thanks', function () {
    return view('thanks');
})->name('thanks');



Route::get('/testimony', [TestimonyFormController::class, 'show'])->name("testimony.show");
Route::post('/testimony', [TestimonyFormController::class, 'store'])->name("testimony.store");
Route::post('/thanks', [TestimonyFormController::class, 'thanks'])->name("testimony.thanks");

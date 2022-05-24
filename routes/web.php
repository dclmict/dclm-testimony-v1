<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CrusadeTourController;
use App\Http\Controllers\TestimonyFormController;


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

Auth::routes(); // laravel auth routes

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get('thanks', function () {
    return view('thanks');
})->name('thanks');

Route::get('/testimony', [TestimonyFormController::class, 'show'])->name("testimony.show");
Route::post('/testimony', [TestimonyFormController::class, 'store'])->name("testimony.store");

Route::get('/thanks#thanks-section', [TestimonyFormController::class, 'thanks'])->name("testimony.thanks");

//crusade-tour routes
Route::get('/crusade-tour', [CrusadeTourController::class, 'create'])->name("crusade-tour.create");
Route::get('/crusade-tours', [CrusadeTourController::class, 'index'])->name("crusade-tour.index");



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Admin Routes 
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function () {

    Route::get('/', [AdminController::class, 'show'])->name("admin.show");
    Route::get("/crusade-tour", [CrusadeTourController::class, 'index'])->name("admin.crusade-tour.index");
    Route::put("/crusade-tour/{id}", [CrusadeTourController::class, 'update'])->name("admin.crusade-tour.update");
    Route::get('/crusade-tour/{id}', [CrusadeTourController::class, 'delete'])->name("admin.crusade-tour.delete");
    Route::get('/crusade-tour/{id}/edit', [CrusadeTourController::class, 'edit'])->name("admin.crusade-tour.edit");

    Route::post('/crusade-tour', [CrusadeTourController::class, 'store'])->name("admin.crusade-tour.store");
    Route::get('/crusade-tour/{id}/active', [CrusadeTourController::class, 'active'])->name("admin.crusade-tour.active");


    // List testimonies

    Route::get('/testimonies', [AdminController::class, 'testimoniesList'])->name("admin.testimonies.list");
});

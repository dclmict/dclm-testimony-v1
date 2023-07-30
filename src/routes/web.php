<?php

use App\Models\Testimony;
use App\Models\CrusadeTour;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CrusadeTourController;
use App\Http\Controllers\TestimonyFormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|g
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Route::get('/register', function () {
    return view('auth.register');
}); */

Auth::routes(['except' => ['register']]); // laravel auth routes

Route::get('thanks', function () {
    return view('thanks');
})->name('thanks');


Route::get('/token', function () {
    return csrf_token(); 
});

// App routes
Route::get('/', [TestimonyFormController::class, 'show'])->name("testimony.show");
Route::post('/testimony/store', [TestimonyFormController::class, 'store'])->name("testimony.store");
Route::get('/thanks#thanks-section', [TestimonyFormController::class, 'thanks'])->name("testimony.thanks");

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name("admin.show");
    Route::get('/testimonies', [AdminController::class, 'testimoniesList'])->name("admin.testimonies.list");
    Route::get('/testimonies/{testimony}', [AdminController::class, 'show'])->name("admin.testimonies.show");
    Route::get('/testimonies/delete/{testimony}', [AdminController::class, 'delete'])->name("admin.testimonies.delete");
    Route::get("/crusade/add", [CrusadeTourController::class, 'create'])->name("admin.crusade.add.create");
    Route::get("/crusade/tour", [CrusadeTourController::class, 'index'])->name("admin.crusade.tour.index");
    Route::get('/crusade/tour/{id}', [CrusadeTourController::class, 'delete'])->name("admin.crusade.tour.delete");
    Route::get('/crusade/tour/{id}/edit', [CrusadeTourController::class, 'edit'])->name("admin.crusade.add.edit");
    Route::get('/crusade/tour/{id}/active', [CrusadeTourController::class, 'active'])->name("admin.crusade.tour.active");
    Route::get('/crusade/tour/{id}/exportPdf', [CrusadeTourController::class, 'exportPdf'])->name("admin.crusade.tour.exportPdf");
    Route::post('/crusade/tour', [CrusadeTourController::class, 'store'])->name("admin.crusade.tour.store");
    Route::put("/crusade/tour/{id}", [CrusadeTourController::class, 'update'])->name("admin.crusade.tour.update");
});
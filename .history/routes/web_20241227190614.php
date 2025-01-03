<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SuperAdmin\FantasticAdminController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\SuperAdmin\DepartmentsController;

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

// radacina proiectului
Route::get('/', function () {
    return view('startApp');
})->name('StartApp');;

// pagina in care userul este notificat ca a creat contul si trebuie sa astepte aprobarea noastra
Route::get('/registration/pending', [RegisteredUserController::class, 'pending'])->name('registration.pending');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// SUPER ADMIN
// Route::get('/fantastic-admin', [FantasticAdminController::class, 'index'])->name('admin.dashboard');

Route::middleware('admin.access')->prefix('fantastic-admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/', [FantasticAdminController::class, 'index'])->name('dashboard');

    // Users management
    Route::get('/users-management', [UserManagementController::class, 'index'])->name('users-management');

    // Accept user
    Route::put('/users/{user}/accept', [UserManagementController::class, 'acceptUser'])->name('users.accept');

    // User logout
    Route::post('/logout', [FantasticAdminController::class, 'destroy'])->name('logout');

    // Delete user
    Route::delete('/users-management/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');


    // utilizatorii din acelasi hotel
    Route::get('/management-hotel', [UserManagementController::class, 'show'])->name('management-hotel');

    // departamentele (acces pt super-admin)
    Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments');
    Route::post('/change-color', [DepartmentsController::class, 'ChangeColorDepartments'])->name('change-color');

});



require __DIR__ . '/auth.php';

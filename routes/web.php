<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsenceRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\VacationRequestController;
use Illuminate\Support\Facades\Route;

// Authentification routes

// Page d'inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
// Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Page de connexion
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password')->middleware('auth');

// Demandes d'absences
Route::resource('absences', AbsenceRequestController::class);
// Demandes de congés
Route::resource('conges', VacationRequestController::class);
// Employes
Route::resource('employes', EmployeController::class);
Route::resource('vacationrequest', VacationRequestController::class);


// Armand

// Tableaux de bord selon le rôle
Route::get('/dashboard', function () {
    // if (auth()->user()->role === 'admin') // Si l'utilisateur est un administrateur
    return view('dashboard/dashboardAdmin/index');
    // Sinon
    // return view('dashboard/dashboardEmploye/index');

})->name('directeur.dashboard');



// Armand

// Route::post('/profil/update', [ProfileController::class, 'updatedProfile'])->name('profil.update');
// Route::put('/profil/update-password', [ProfileController::class, 'updatePassword'])->name('profil.updatePassword');
// // Routes pour la gestion du mot de passe oublié
// Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
// Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email'); 
// Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

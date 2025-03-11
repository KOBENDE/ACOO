<?php

use App\Http\Controllers\AbsenceRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VacationRequestController;
use Illuminate\Support\Facades\Route;

// Authentification routes

// Page d'inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Page de connexion
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'LoginValidation'])->name('connection');
//Pour la deconnexion 
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//Pour le profil 
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::put('/profile/update-password', [AuthController::class, 'updatePassword'])->name('profile.update.password');
// Demandes d'absences
Route::resource('absences', AbsenceRequestController::class);
Route::post('/absences/{absence}/approuver', [VacationRequestController::class, 'approuver'])->name('absences.approuver');
Route::post('/absences/{absence}/rejeter', [VacationRequestController::class, 'rejeter'])->name('absences.rejeter');
// Demandes de congés
Route::resource('conges', VacationRequestController::class);
Route::post('/conges/{conge}/approuver', [VacationRequestController::class, 'approuver'])->name('conges.approuver');
Route::post('/conges/{conge}/rejeter', [VacationRequestController::class, 'rejeter'])->name('conges.rejeter');
// Employes
Route::resource('employes', EmployeController::class);
Route::resource('vacationrequest', VacationRequestController::class);

// Tableaux de bord selon le rôle
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'employe') {
        return view('dashboard/dashboardEmploye/index');
    } else {
        return redirect()->route('admin.dashboard');
    }
})->name('directeur.dashboard');

Route::get('/admin/dashboard', [VacationRequestController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');

// Routes pour la gestion du mot de passe oublié
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
//Liste des employes suivant les roles de chacun 
Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index')->middleware('auth');
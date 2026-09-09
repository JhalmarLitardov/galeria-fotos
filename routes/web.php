<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Middleware\TrackVisitor;
use App\Http\Controllers\Admin\AppearanceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\CustomForgotPasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Rutas de recuperación de contraseña personalizadas
Route::get('admin/forgot-password', [CustomForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('admin/forgot-password', [CustomForgotPasswordController::class, 'resetPassword'])->name('password.update-custom');

/* Auth::routes(['verify' => true]); // Esto habilita automáticamente las rutas de password.reset*/

// Zona Pública (Registra visitas con el middleware)
Route::middleware([TrackVisitor::class])->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('home');
});

// Autenticación de Administrador
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('logout');

// Panel de Administración (Protegido por Auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de Galerías (Fotos y Videos)
    Route::resource('galleries', GalleryController::class);

    // Gestión de Apariencia (Favicon, Fondo Login, Logo)
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/appearance', [AppearanceController::class, 'edit'])->name('appearance.edit');
    Route::post('/appearance', [AppearanceController::class, 'update'])->name('appearance.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // ... tus otras rutas de admin ...
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('home');

Route::prefix('auth/google')->group(function () {
    Route::get('/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::post('/disconnect', [SocialAuthController::class, 'disconnectGoogle'])->name('google.disconnect');
});

// Auth Routes dengan AJAX support
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Registration Routes
    Route::get('/register', [AuthController::class, 'formRegister'])->name('registerform');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Availability Checks (AJAX)
    Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check.email');
    Route::post('/check-username', [AuthController::class, 'checkUsername'])->name('check.username');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route untuk AJAX auth checks
    Route::get('/auth/check', [AuthController::class, 'checkAuth'])->name('auth.check');
    Route::get('/auth/user', [AuthController::class, 'getUserInfo'])->name('auth.user');
});

// Route Admin

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'role:superadmin,admin,manager,operator'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::prefix('user-manager')
            ->name('user-manager.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'userManager'])->name('index');
                Route::get('/user', [AdminController::class, 'semuaUser'])->name('user');
                Route::post('/store', [AdminController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('delete');

                Route::controller(RoleController::class)->prefix('roles')->name('roles.')->group(function () {
                    Route::get('/page', 'page')->name('page');
                    Route::get('/', 'index')->name('index');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/update/{id}', 'update')->name('update');
                    Route::delete('/delete/{id}', 'destroy')->name('delete');
                });

                Route::controller(PermissionController::class)->prefix('permissions')->name('permissions.')->group(function () {
                    Route::get('/page', 'page')->name('page');
                    Route::get('/', 'index')->name('index');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/update/{id}', 'update')->name('update');
                    Route::delete('/delete/{id}', 'destroy')->name('delete');
                });

                Route::controller(UserRoleController::class)->prefix('user-role')->name('user-role.')->group(function () {
                    Route::get('/page', 'page')->name('page');
                    Route::get('/', 'index')->name('index');
                    Route::get('/{id}', 'show')->name('show');
                    Route::post('/assign', 'assign')->name('assign');
                });

                Route::controller(RolePermissionController::class)
                    ->prefix('role-permission')
                    ->name('role-permission.')
                    ->group(function () {
                        Route::get('/page', 'page')->name('page');
                        Route::get('/', 'index')->name('index');
                        Route::get('/role/{id}', 'showRole')->name('show');
                        Route::post('/assign', 'assign')->name('assign');
                    });
            });
    });

// Route Member
Route::get('/{keyname}', [MemberController::class, 'index'])->middleware(['role:superadmin,admin,member', 'validate.keyname'])->name('profile.detail');
Route::prefix('{keyname}')
    ->middleware(['web', 'role:superadmin,admin,member', 'validate.keyname'])
    ->group(function () {
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    });

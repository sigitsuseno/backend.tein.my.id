<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('home');
// Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
// ✅ form login hanya untuk tamu
Route::get('/login', [AuthController::class, 'formLogin'])
    ->middleware('guest')
    ->name('loginform');

// ✅ aksi login (POST) tidak perlu middleware guest
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

// ✅ register (GET & POST)
Route::get('/register', [AuthController::class, 'formRegister'])
    ->middleware('guest')
    ->name('registerform');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
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
                Route::get('/user', [AdminController::class, 'manageUser'])->name('user');
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
                    Route::get('/', 'index')->name('index');
                    Route::post('/assign', 'assign')->name('assign');
                });
            });
    });

Route::get('/{keyname}', [MemberController::class, 'index'])->middleware(['role:superadmin,admin,member', 'validate.keyname'])->name('profile.detail');
Route::prefix('{keyname}')
    ->middleware(['web', 'role:superadmin,admin,member', 'validate.keyname'])
    ->group(function () {
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    });

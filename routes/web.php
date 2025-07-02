<?php

use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\DivisionController;
use App\Http\Controllers\backend\admin\ImportantLinkController;
use App\Http\Controllers\backend\admin\MemberZoneTypeController;
use App\Http\Controllers\backend\admin\ProfileController;
use App\Http\Controllers\backend\admin\ZillaController;
use App\Http\Controllers\backend\AuthenticationController;
use App\Http\Controllers\backend\operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\backend\operator\ProfileController as OperatorProfileController;
use App\Http\Controllers\FrontEndController;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\OperatorAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

// frontend 

Route::get('/', [FrontEndController::class, 'home'])->name('home');


// backend 
Route::match(['get', 'post'], 'login', [AuthenticationController::class, 'login'])->name('login');
// route prefix 
Route::prefix('admin')->group(function () {
    // route name prefix 
    Route::name('admin.')->group(function () {
        //middleware 
        Route::middleware(AdminAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            // member zone 
            Route::match(['get', 'post'], 'member-zone-type', [MemberZoneTypeController::class, 'memberZoneTypeList'])->name('member-zone-type');
            Route::get('member-zone-type/delete/{id}', [MemberZoneTypeController::class, 'memberZoneTypeDelete'])->name('member-zone-type.delete');



            Route::match(['get', 'post'], 'link/add', [ImportantLinkController::class, 'link_add'])->name('link.add');

            Route::match(['get', 'post'], 'link/edit/{id}', [ImportantLinkController::class, 'link_edit'])->name('link.edit');
            Route::get('link/list', [ImportantLinkController::class, 'link_list'])->name('link.list');
            Route::get('link/delete/{id}',[ImportantLinkController::class,'link_delete'])->name('link.delete');

            Route::match(['get', 'post'], 'division', [DivisionController::class, 'division_list'])->name('division');
            Route::get('division/delete/{id}', [DivisionController::class, 'division_delete'])->name('division.delete');
            
            Route::match(['get', 'post'], 'zilla', [ZillaController::class, 'zilla_list'])->name('zilla');
            
            Route::get('zilla/delete/{id}', [ZillaController::class, 'zilla_delete'])->name('division.delete');
        });
    });
});
// Advocate 
// route prefix
Route::prefix('operator')->group(function () {
    // route name prefix
    Route::name('operator.')->group(function () {
        //middleware 
        Route::middleware(OperatorAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [OperatorProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [OperatorProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [OperatorProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard 
            Route::get('dashboard', [OperatorDashboardController::class, 'dashboard'])->name('dashboard');
        });
    });
});

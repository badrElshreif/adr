<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['middleware' => 'api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', \App\Company\Actions\Auth\LoginAdminAction::class);
        Route::post('/register', \App\Company\Actions\Auth\RegisterCompanyAction::class);
        Route::post('/resend-verification-code', \App\Company\Actions\Auth\ResendVerificationCodeAction::class);
        Route::post('/verification-code', \App\Company\Actions\Auth\GetVerificationCodeAction::class);
        Route::post('/verify-account', \App\Company\Actions\Auth\VerifyAccountAction::class);
        Route::post('/forget-password', \App\Company\Actions\Auth\ForgetPasswordAction::class);
        Route::post('/verify-token', \App\Company\Actions\Auth\VerifyResetCompanyPasswordCodeAction::class);
        Route::post('/reset-password', \App\Company\Actions\Auth\ResetPasswordAction::class);

    });
    Route::middleware(['auth:company', 'CompanyMiddleware', 'IsActiveAdmin'])->group(function () {
        Route::get('/statistics', \App\AppContent\Actions\Statistics\GetStatisticsAction::class)->name('statistics.index');
        Route::post('/auth/logout', \App\Company\Actions\Auth\LogoutAdminAction::class);
        Route::get('/home', \App\AppContent\Actions\Statistics\GetHomeAction::class)->name('home.index');

        Route::group(['prefix' => 'auth/profile'], function () {
            Route::get('/{id}', \App\Company\Actions\ShowCompanyAction::class);
            Route::put('/', \App\Company\Actions\Auth\UpdateProfileAction::class)->name('admins.update_profile');
            Route::put('/company', \App\Company\Actions\Auth\UpdateProfileCompanyAction::class)->name('admins.update_profile_Company');
            //  Route::put("{id}/toggle-chat-status", \App\Company\Actions\ToggleCompanyChatStatusAction::class)->name("admins.update_chat");
            Route::put('/bank-setting', \App\Company\Actions\Auth\UpdateBankDataAction::class)->name('admins.update_bank-setting');
            Route::put('/change-password', \App\Company\Actions\Auth\ChangePasswordAction::class)->name('admins.update_password');
            Route::put('/change-email', \App\Company\Actions\Auth\ChangeEmailAction::class)->name('admins.update_email');;
        });

        Route::group(['prefix' => 'employees'], function () {
            Route::get('/', \App\Employee\Actions\ListEmployeesAction::class)->name('employees.index');
            Route::get('/export-to-excel', \App\Employee\Actions\ExportEmployeesToExcelAction::class);
            Route::get('/{id}', \App\Employee\Actions\GetEmployeeAction::class)->name('employees.show');
            Route::post('/', \App\Employee\Actions\CreateEmployeeAction::class)->name('employees.store');
            Route::put('/{id}', \App\Employee\Actions\UpdateEmployeeAction::class)->name('employees.update');
            Route::delete('/{id}', \App\Employee\Actions\DeleteEmployeeAction::class)->name('employees.destroy');
            Route::put('/{id}/toggle-status', \App\Employee\Actions\ToggleEmployeeStatusAction::class)->name('employees.toggle_status');
        });

        Route::group(['prefix' => 'offices'], function () {
            Route::get('/', \App\Office\Actions\ListOfficesAction::class)->name('offices.index');
            Route::get('/{id}', \App\Office\Actions\GetOfficeAction::class)->name('offices.show');
            Route::post('/', \App\Office\Actions\CreateOfficeAction::class)->name('offices.store');
            Route::put('/{id}', \App\Office\Actions\UpdateOfficeAction::class)->name('offices.update');
            Route::delete('/{id}', \App\Office\Actions\DeleteOfficeAction::class)->name('offices.destroy');
            Route::put('/{id}/toggle-status', \App\Office\Actions\ToggleOfficeStatusAction::class)->name('offices.toggle_status');
        });

        Route::get("/users", \App\User\Actions\User\ListUsersAction::class)->name("users.index");
        Route::get('/settings', \App\AppContent\Actions\Setting\GetSettingsAction::class)->name('settings.index');

        Route::group(['prefix' => 'uploader'], function () {
            Route::post('/', \App\Uploader\Actions\API\UploadFileAction::class)->name('uploader.store');
            Route::post('/multiple-files', \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name('uploader.multiple_files');
            Route::post('/delete', \App\Uploader\Actions\API\DeleteFileAction::class)->name('uploader.destroy');
        });

    });
});

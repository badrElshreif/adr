<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});
Route::group(['middleware' => 'api'], function ()
{
    Route::group(['prefix' => 'uploader'], function ()
    {
        Route::post('/', \App\Uploader\Actions\API\UploadFileAction::class)->name('uploader.store');
        Route::post('/multiple-files', \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name('uploader.multiple_files');
        Route::post('/delete', \App\Uploader\Actions\API\DeleteFileAction::class)->name('uploader.destroy');
    });

    Route::group(['prefix' => 'auth'], function ()
    {
        Route::post('/register', \App\User\Actions\Auth\RegisterUserAction::class);
        Route::post('/delivery-register', \App\User\Actions\Auth\RegisterDeliveryAction::class);
        Route::post('/resend-verification-code', \App\User\Actions\Auth\ResendVerificationCodeAction::class);
        Route::get('/verification-code', \App\User\Actions\Auth\GetVerificationCodeAction::class);
        Route::post('/verify-account', \App\User\Actions\Auth\VerifyAccountAction::class);
        Route::post('/login', \App\User\Actions\Auth\LoginUserAction::class);
        Route::post('/forget-password', \App\User\Actions\Auth\ForgetUserPasswordAction::class);
        Route::post('/verify-token', \App\User\Actions\Auth\VerifyResetUserPasswordCodeAction::class);
        Route::post('/reset-password', \App\User\Actions\Auth\ResetUserPasswordAction::class);
    });

    Route::group(['middleware' => ['IsActiveUser', 'auth:api']], function ()
    {
        Route::post('/auth/logout', \App\User\Actions\Auth\LogoutUserAction::class);
        Route::post('/auth/change-country', \App\User\Actions\Auth\UpdateUserCountryAction::class);
        Route::post('/auth/delete-account', \App\User\Actions\Auth\DeleteAccountAction::class);
        Route::group(['prefix' => '/profile'], function ()
        {
            Route::post('/change-password', \App\User\Actions\User\ChangePasswordAction::class);
            Route::get('/', \App\User\Actions\User\GetProfileAction::class);
            Route::put('/', \App\User\Actions\User\UpdateUserProfileAction::class);
            Route::post('/verify-phone', \App\User\Actions\User\UpdatePhoneAction::class);
            Route::group(['prefix' => '/user-addresses'], function ()
            {
                Route::get('/', \App\User\Actions\UserAddress\ListUserAddressesAction::class);
                Route::post('/', \App\User\Actions\UserAddress\CreateUserAddressAction::class);
                Route::get('/{id}', \App\User\Actions\UserAddress\ShowUserAddressAction::class);
                Route::put('/{id}', \App\User\Actions\UserAddress\UpdateUserAddressAction::class);
                Route::delete('/{id}', \App\User\Actions\UserAddress\DeleteUserAddressAction::class);
            });
        });

        Route::group(['prefix' => 'user-notifications'], function ()
        {
            Route::get('/', \App\User\Actions\Notifications\ListUserNotificationsAction::class);
            Route::get('/count', \App\User\Actions\Notifications\GetUnreadUserNotificationsAction::class);
        });

    });
});

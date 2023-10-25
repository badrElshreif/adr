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

Route::group(['middleware' => 'api'], function ()
{
    Route::group(['prefix' => 'auth'], function ()
    {
        Route::post('/login', \App\Admin\Actions\Auth\LoginAdminAction::class);
        Route::post('/forget-password', \App\Admin\Actions\Auth\ForgetPasswordAction::class);
        Route::post('/reset-password', \App\Admin\Actions\Auth\ResetPasswordAction::class);
    });

    Route::middleware(['auth:admin', 'SuperAdminMiddleware', 'IsActiveAdmin'])->group(function ()
    {
        Route::post('/auth/logout', \App\Admin\Actions\Auth\LogoutAdminAction::class);

        Route::group(['prefix' => 'auth/profile'], function ()
        {
            Route::put('/', \App\Admin\Actions\Auth\UpdateProfileAction::class)->name('admins.update_profile');
            Route::put('/change-password', \App\Admin\Actions\Auth\ChangePasswordAction::class)->name('admins.update_password');
        });

        Route::group(['prefix' => 'uploader'], function ()
        {
            Route::post('/', \App\Uploader\Actions\API\UploadFileAction::class)->name('uploader.store');
            Route::post('/multiple-files', \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name('uploader.multiple_files');
            Route::post('/delete', \App\Uploader\Actions\API\DeleteFileAction::class)->name('uploader.destroy');
        });

        Route::delete('/attachments/{id}', \App\Uploader\Actions\DeleteAttachmentAction::class);

        Route::group(['prefix' => 'permissions'], function ()
        {
            Route::get('/', \App\Admin\Actions\Permission\ListPermissionsAction::class)->name('permissions.index');
        });

        Route::group(['prefix' => 'roles'], function ()
        {
            Route::get('/', \App\Admin\Actions\Permission\ListRolesAction::class)->name('roles.index')->middleware('can:roles.index');
            Route::get('/{id}', \App\Admin\Actions\Permission\ShowRoleAction::class)->name('roles.show');
            Route::delete('/{id}', \App\Admin\Actions\Permission\DeleteRoleAction::class)->name('roles.destroy')->middleware('can:roles.delete');
            Route::put('/{id}/toggle-status', \App\Admin\Actions\Permission\ToggleRoleStatusAction::class)->name('roles.toggle_status')->middleware('can:roles.update');
            Route::post('/', \App\Admin\Actions\Permission\CreateRoleAction::class)->name('roles.store')->middleware('can:roles.create');
            Route::put('/{id}', \App\Admin\Actions\Permission\UpdateRoleAction::class)->name('roles.update')->middleware('can:roles.update');
        });

        Route::group(['prefix' => 'admins'], function ()
        {
            Route::get('/', \App\Admin\Actions\Admin\ListAdminsAction::class)->name('admins.index')->middleware('can:admins.index');
            Route::get('/export-to-excel', \App\Admin\Actions\Admin\ExportAdminsToExcelAction::class)->name('admins.export')->middleware('can:admins.index');
            Route::get('/{id}', \App\Admin\Actions\Admin\GetAdminAction::class)->name('admins.show');
            Route::post('/', \App\Admin\Actions\Admin\CreateAdminAction::class)->name('admins.store')->middleware('can:admins.create');
            Route::put('/{id}', \App\Admin\Actions\Admin\UpdateAdminAction::class)->name('admins.update')->middleware('can:admins.update');
            Route::delete('/{id}', \App\Admin\Actions\Admin\DeleteAdminAction::class)->name('admins.destroy')->middleware('can:admins.delete');
            Route::put('/{id}/toggle-status', \App\Admin\Actions\Admin\ToggleAdminStatusAction::class)->name('admins.toggle_status')->middleware('can:admins.update');
            // Route::post("/{id}/permissions", \App\Admin\Actions\Admin\AssignPermissionsToAdminAction::class)->name("admins.assignPermissions");

        });

        Route::group(['prefix' => 'pages'], function ()
        {
            Route::get('/', \App\AppContent\Actions\Page\ListPagesAction::class)->name('pages.index')->middleware('can:pages.index');
            Route::get('/{slug}', \App\AppContent\Actions\Page\GetPageAction::class)->name('pages.index');
            Route::put('/{slug}', \App\AppContent\Actions\Page\UpdatePageAction::class)->name('pages.update')->middleware('can:pages.index');
            Route::post('/', \App\AppContent\Actions\Page\CreatePageAction::class)->name('pages.create')->middleware('can:pages.index');
            Route::put('/{slug}/toggle-status', \App\AppContent\Actions\Page\TogglePageStatusAction::class)->name('pages.toggle_status');
            Route::delete('/{slug}', \App\AppContent\Actions\Page\DeletePageAction::class)->name('pages.destroy');
        });

        Route::group(['prefix' => 'home-content'], function ()
        {
            Route::get('/', \App\AppContent\Actions\HomeContent\ListContentAction::class)->name('content.index');
            Route::get('/{id}', \App\AppContent\Actions\HomeContent\GetContentAction::class)->name('content.show');
            Route::put('/{id}', \App\AppContent\Actions\HomeContent\UpdateContentAction::class)->name('content.update');
//            Route::post("/", \App\AppContent\Actions\Page\CreatePageAction::class)->name("content.create")->middleware('can:setting.index');
            Route::put('/{id}/toggle-status', \App\AppContent\Actions\HomeContent\ToggleContentStatusAction::class)->name('content.toggle_status');
//            Route::delete("/{slug}", \App\AppContent\Actions\Page\DeletePageAction::class)->name("content.destroy");
        });
        Route::group(['prefix' => 'contact-us'], function ()
        {
            Route::get('/', \App\AppContent\Actions\ContactUs\ListContactUsAction::class)->name('contact_us.index')->middleware('can:contact_us.index');
            Route::get('/export-to-excel', \App\AppContent\Actions\ContactUs\ExportContactUsToExcelAction::class)->name('contact_us.export')->middleware('can:contact_us.index');
            Route::post('/', \App\AppContent\Actions\ContactUs\CreateContactUsAction::class)->name('contact_us.store')->middleware('can:contact_us.create');
            Route::get('/{id}', \App\AppContent\Actions\ContactUs\ShowContactUsAction::class)->name('contact_us.show');
            Route::put('/{id}', \App\AppContent\Actions\ContactUs\UpdateContactUsAction::class)->name('contact_us.update')->middleware('can:contact_us.update');
            Route::delete('/{id}', \App\AppContent\Actions\ContactUs\DeleteContactUsAction::class)->name('contact_us.destroy')->middleware('can:contact_us.delete');
        });
        Route::group(['prefix' => 'slider-content'], function ()
        {
            Route::get('/', \App\HomeSlider\Actions\ListSliderAction::class)->name('slider.index')->middleware('can:settings.index');
            Route::get('/{id}', \App\HomeSlider\Actions\ShowSliderAction::class)->name('slider.index');
            Route::put('/{id}', \App\HomeSlider\Actions\UpdateSliderAction::class)->name('slider.update')->middleware('can:settings.index');
            Route::post('/', \App\HomeSlider\Actions\CreateSliderAction::class)->name('slider.create')->middleware('can:settings.index');
            Route::put('/{id}/toggle-status', \App\HomeSlider\Actions\ToggleSliderStatusAction::class)->name('slider.toggle_status');
            Route::delete('/{slug}', \App\HomeSlider\Actions\DeleteSliderAction::class)->name('slider.destroy');
        });

        Route::group(['prefix' => 'users'], function ()
        {
            Route::get('/', \App\User\Actions\User\ListUsersAction::class)->name('users.index');
            Route::get('/export-to-excel', \App\User\Actions\User\ExportUsersToExcelAction::class)->name('users.export')->middleware('can:users.index');
            Route::get('/{id}', \App\User\Actions\User\ShowUserAction::class)->name('users.show');
            Route::post('/', \App\User\Actions\User\CreateUserAction::class)->name('users.store')->middleware('can:users.create');
            Route::post('/create-delivery', \App\User\Actions\Auth\RegisterDeliveryAction::class)->middleware('can:deliveries.create');
            Route::put('/{id}', \App\User\Actions\User\UpdateUserAction::class)->name('users.update')->middleware('can:users.update');
            Route::delete('/{id}', \App\User\Actions\User\DeleteUserAction::class)->name('users.destroy')->middleware('can:users.delete');
            Route::delete('/delivery/{id}', \App\User\Actions\User\DeleteDeliveryAction::class)->name('users.destroy')->middleware('can:users.delete');
            Route::put('/{id}/toggle-status', \App\User\Actions\User\ToggleUserStatusAction::class)->name('users.toggle_status')->middleware('can:users.update');
            Route::get('/{id}/addresses', \App\User\Actions\User\ListUserAddressesAction::class)->name('users.addresses');
            Route::put('accept-reject-delivery/{id}', \App\User\Actions\User\AcceptRejectDeliveryAction::class)->name('deliveries.update');

        });

        Route::group(["prefix" => "rooms"], function ()
        {
            Route::get("/", \App\Room\Actions\ListRoomsAction::class)->name("rooms.index");
            Route::get("/{id}", \App\Room\Actions\ShowRoomAction::class)->name("rooms.show");
            Route::post("/", \App\Room\Actions\CreateRoomAction::class)->name("rooms.store");
            Route::put("/{id}", \App\Room\Actions\UpdateRoomAction::class)->name("rooms.update");
            Route::delete("/{id}", \App\Room\Actions\DeleteRoomAction::class)->name("rooms.destroy");
            Route::put("/{id}/toggle-status", \App\Room\Actions\ToggleRoomStatusAction::class)->name("rooms.toggle_status");
        });

        Route::group(["prefix" => "files"], function ()
        {
            Route::get("/", \App\File\Actions\ListFilesAction::class)->name("files.index");
            Route::get("/{id}", \App\File\Actions\ShowFileAction::class)->name("files.show");
            Route::post("/", \App\File\Actions\CreateFileAction::class)->name("files.store");
            Route::put("/{id}", \App\File\Actions\UpdateFileAction::class)->name("files.update");
            Route::delete("/{id}", \App\File\Actions\DeleteFileAction::class)->name("files.destroy");
            Route::put("/{id}/toggle-status", \App\File\Actions\ToggleFileStatusAction::class)->name("files.toggle_status");
        });

        Route::group(['prefix' => 'notifications'], function ()
        {
            Route::get('/', \App\Notification\Actions\ListNotificationsAction::class)->name('notifications.index');
            Route::get('/{id}', \App\Notification\Actions\GetNotificationAction::class)->name('notifications.show');
            Route::post('/', \App\Notification\Actions\SendNotificationAction::class)->name('notifications.store');
            Route::delete('/{id}', \App\Notification\Actions\DeleteNotificationAction::class)->name('notifications.destroy');
        });

        Route::group(['prefix' => 'received-notifications'], function ()
        {
            Route::get('/', \App\Admin\Actions\Notifications\ListUserNotificationsAction::class);
            Route::get('/count', \App\Admin\Actions\Notifications\GetUnreadUserNotificationsAction::class);
        });

        Route::group(['prefix' => 'settings'], function ()
        {
            Route::get('/', \App\AppContent\Actions\Setting\GetSettingsAction::class)->name('settings.index');
            Route::post('/', \App\AppContent\Actions\Setting\UpdateSettingsAction::class)->name('settings.store')->middleware('can:settings.index');
        });

        Route::get('/statistics', \App\AppContent\Actions\Statistics\GetStatisticsAction::class)->name('statistics.index');

        Route::group(["prefix" => "packages"], function ()
        {
            Route::get("/", \App\Package\Actions\ListPackagesAction::class)->name("packages.index")->middleware('can:packages.index');
            Route::get("/{id}", \App\Package\Actions\ShowPackageAction::class)->name("packages.show");
            Route::post("/", \App\Package\Actions\CreatePackageAction::class)->name("packages.store")->middleware('can:packages.create');
            Route::put("/{id}", \App\Package\Actions\UpdatePackageAction::class)->name("packages.update")->middleware('can:packages.update');
            Route::delete("/{id}", \App\Package\Actions\DeletePackageAction::class)->name("packages.destroy")->middleware('can:packages.delete');
            Route::put("/{id}/toggle-status", \App\Package\Actions\TogglePackageStatusAction::class)->name("packages.toggle_status")->middleware('can:packages.update');
        });
    });
});

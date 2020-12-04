<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\User;

Auth::routes();

//Admin

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'IndexController@index')->name('home');

    // Users
    Route::group(['prefix' => 'users'], function () {
        Route::group(['middleware' => 'can:index,' . User::class], function () {
            Route::get('', 'UserController@index')->name('users');
        });
        Route::group(['middleware' => 'can:create,'  . User::class], function () {
            Route::get('create', 'UserController@create')->name('create_user');
            Route::post('', 'UserController@store')->name('store_user');
        });
        Route::group(['middleware' => 'can:update,user'], function () {
            Route::get('{user}/edit', 'UserController@edit')->name('edit_user');
            Route::put('{user}', 'UserController@update')->name('update_user');
        });
        Route::group(['middleware' => 'can:delete,user'], function () {
            Route::get('{user}/delete', 'UserController@remove')->name('remove_user');
            Route::delete('{user}', 'UserController@destroy')->name('destroy_user');
        });
        Route::group(['middleware' => 'can:changePassword,user'], function () {
            Route::get('{user}/change-password', 'UserController@changePassword')
                ->name('change_password_user')
            ;
            Route::put('{user}/change-password', 'UserController@storePassword')
                ->name('store_password_user')
            ;
        });
        Route::group(['middleware' => 'can:changeRole,user'], function () {
            Route::get('{user}/change-role', 'UserController@changeRole')->name('change_role_user');
            Route::put('{user}/change-role', 'UserController@storeRole')->name('store_role_user');
        });
        Route::group(['middleware' => 'can:view,user'], function () {
            Route::get('{user}', 'UserController@show')->name('show_user');
        });
    });

    // My-profile
    Route::group(['prefix' => 'my-profile'], function () {
        Route::get('', 'UserController@myProfile')->name('my_profile');
        Route::get('edit', 'UserController@editMyProfile')->name('my_profile_edit');
        Route::put('update', 'UserController@updateMyProfile')->name('my_profile_update');
        Route::get('change-password', 'UserController@changePasswordMyProfile')->name('my_profile_change_password');
        Route::put('change-password', 'UserController@storePasswordMyProfile')->name('my_profile_store_password');
    });

    // Site
    Route::group(['prefix' => 'site'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Site::class], function () {
            Route::get('', 'SiteController@index')->name('site');
        });

        Route::group(['middleware' => 'can:create,' . \App\Models\Site::class], function () {
            Route::get('create', 'SiteController@create')->name('create_site');
            Route::post('', 'SiteController@store')->name('store_site');
        });
        Route::group(['middleware' => 'can:update,' . \App\Models\Site::class], function () {
            Route::get('{site}/edit', 'SiteController@edit')->name('edit_site');
            Route::put('{site}', 'SiteController@update')->name('update_site');;
        });
        Route::group(['middleware' => 'can:delete,' . \App\Models\Site::class], function () {
            Route::get('{site}/delete', 'SiteController@remove')->name('remove_site');
            Route::delete('{site}', 'SiteController@destroy')->name('destroy_site');
        });

        Route::group(['middleware' => 'can:show,' . \App\Models\Site::class], function () {
            Route::get('{site}', 'SiteController@show')->name('show_site');
        });
    });

    // Provider
    Route::group(['prefix' => 'provider'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Provider::class], function () {
            Route::get('', 'ProviderController@index')->name('provider');
        });

        Route::group(['middleware' => 'can:create,' . \App\Models\Provider::class], function () {
            Route::get('create', 'ProviderController@create')->name('create_provider');
            Route::post('', 'ProviderController@store')->name('store_provider');
        });
        Route::group(['middleware' => 'can:update,' . \App\Models\Provider::class], function () {
            Route::get('{provider}/edit', 'ProviderController@edit')->name('edit_provider');
            Route::put('{provider}', 'ProviderController@update')->name('update_provider');;
        });
        Route::group(['middleware' => 'can:delete,' . \App\Models\Provider::class], function () {
            Route::get('{provider}/delete', 'ProviderController@remove')->name('remove_provider');
            Route::delete('{provider}', 'ProviderController@destroy')->name('destroy_provider');
        });
        Route::group(['middleware' => 'can:show,provider'], function () {
            Route::get('{provider}', 'ProviderController@show')->name('show_provider');
        });
    });

    // Layout
    Route::group(['prefix' => 'layout'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Layout::class], function () {
            Route::get('', 'LayoutController@index')->name('layout');
        });
        Route::group(['middleware' => 'can:index,' . \App\Models\Layout::class], function () {
            Route::get('{layoutFile}/destroy-file/', 'LayoutController@destroyLayoutFile')->name('delate_layout_file');
        });
        Route::group(['middleware' => 'can:create,' . \App\Models\Layout::class], function () {
            Route::get('create', 'LayoutController@create')->name('create_layout');
            Route::post('', 'LayoutController@store')->name('store_layout');
        });
        Route::group(['middleware' => 'can:update,' . \App\Models\Layout::class], function () {
            Route::get('{layout}/edit', 'LayoutController@edit')->name('edit_layout');
            Route::put('{layout}', 'LayoutController@update')->name('update_layout');;
        });
        Route::group(['middleware' => 'can:delete,' . \App\Models\Layout::class], function () {
            Route::get('{layout}/delete', 'LayoutController@remove')->name('remove_layout');
            Route::delete('{layout}', 'LayoutController@destroy')->name('destroy_layout');
        });
        Route::group(['middleware' => 'can:show,layout'], function () {
            Route::get('{layout}', 'LayoutController@show')->name('show_layout');
        });
        Route::group(['middleware' => 'can:update,' . \App\Models\Layout::class], function () {
            Route::post('{layout}/add-layout-file', 'LayoutController@addLayoutFile')->name('add_layout_file_layout');
        });
    });

    // Template
    Route::group(['prefix' => 'template'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Layout::class], function () {
            Route::get('', 'TemplateController@index')->name('template');
        });
        Route::group(['middleware' => 'can:index,' . \App\Models\Layout::class], function () {
            Route::get('{templateFile}/destroy-file/', 'TemplateController@destroyTemplateFile')->name('delate_template_file');
        });

        Route::group(['middleware' => 'can:create,' . \App\Models\Layout::class], function () {
            Route::get('create', 'TemplateController@create')->name('create_template');
            Route::post('', 'TemplateController@store')->name('store_template');
        });
        Route::group(['middleware' => 'can:update,' . \App\Models\Layout::class], function () {
            Route::get('{template}/edit', 'TemplateController@edit')->name('edit_template');
            Route::put('{template}', 'TemplateController@update')->name('update_template');;
        });
        Route::group(['middleware' => 'can:delete,' . \App\Models\Layout::class], function () {
            Route::get('{template}/delete', 'TemplateController@remove')->name('remove_template');
            Route::delete('{template}', 'TemplateController@destroy')->name('destroy_template');
        });
        Route::group(['middleware' => 'can:show,' . \App\Models\Layout::class], function () {
            Route::get('{template}', 'TemplateController@show')->name('show_template');
        });
        Route::group(['middleware' => 'can:index,' . \App\Models\Layout::class], function () {
            Route::post('{template}/add-template-file', 'TemplateController@addTemplateFile')->name('add_template_file');
        });
    });

    // Feedback
    Route::group(['prefix' => 'feedback'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Feedback::class], function () {
            Route::get('', 'FeedbackController@index')->name('feedback');
        });
        Route::group(['middleware' => 'can:update,' . \App\Models\Feedback::class], function () {
            Route::get('{feedback}/edit', 'FeedbackController@edit')->name('edit_feedback');
            Route::put('{feedback}', 'FeedbackController@update')->name('update_feedback');;
        });
        Route::group(['middleware' => 'can:delete,' . \App\Models\Feedback::class], function () {
            Route::get('{feedback}/delete', 'FeedbackController@remove')->name('remove_feedback');
            Route::delete('{feedback}', 'FeedbackController@destroy')->name('destroy_feedback');
        });
        Route::group(['middleware' => 'can:show,' . \App\Models\Feedback::class], function () {
            Route::get('{feedback}', 'FeedbackController@show')->name('show_feedback');
        });
    });

    // Category
    Route::group(['prefix' => 'categories'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Provider::class], function () {
            Route::get('', 'CategoryController@index')->name('categories');
        });
    });

    // Tag
    Route::group(['prefix' => 'tags'], function () {
        Route::group(['middleware' => 'can:index,' . \App\Models\Provider::class], function () {
            Route::get('', 'TagController@index')->name('tags');
        });
    });
});

Route::get('/logout', 'Auth\LoginController@logout');

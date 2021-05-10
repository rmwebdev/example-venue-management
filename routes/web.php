<?php

use Illuminate\Support\Facades\{Route, Auth};

Route::get('/', 'HomeController@index');
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/event-type/{slug}', 'EventTypeController@index')->name('event_type');
Route::get('/location/{slug}', 'LocationController@index')->name('location');
Route::get('/venues/{slug}/{id}', 'VenueController@show')->name('venues.show');
Route::view('about', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Locations
    Route::delete('locations/destroy', 'LocationsController@massDestroy')->name('locations.massDestroy');
    Route::resource('locations', 'LocationsController');

    // Event Types
    Route::delete('event-types/destroy', 'EventTypesController@massDestroy')->name('event-types.massDestroy');
    Route::post('event-types/media', 'EventTypesController@storeMedia')->name('event-types.storeMedia');
    Route::post('event-types/ckmedia', 'EventTypesController@storeCKEditorImages')->name('event-types.storeCKEditorImages');
    Route::resource('event-types', 'EventTypesController');

    // Venues
    Route::delete('venues/destroy', 'VenuesController@massDestroy')->name('venues.massDestroy');
    Route::post('venues/media', 'VenuesController@storeMedia')->name('venues.storeMedia');
    Route::post('venues/ckmedia', 'VenuesController@storeCKEditorImages')->name('venues.storeCKEditorImages');
    Route::resource('venues', 'VenuesController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
